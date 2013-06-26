<?php
/**
 *
 */

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Collection\Form\ChampTypeElementForm;
use Zend\Form\Form;
use Zend\Form\Element;
use Exception;
use Collection\Entity\Media;
use Collection\Entity\Data;
use Zend\File\Transfer\Adapter\Http;
use Zend\Json\Json;

/**
 * Controleur des medias
 *
 * Permet la création, lecture, modification et suppression des médias
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class MediaController extends AbstractActionController
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * Initialisation de l'Entity Manager
	 *
	 * @param Doctrine\ORM\EntityManager
	 * @return void
	 */
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * Retourne l'Entity Manager
	 *
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		if ($this->em === null) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}

		return $this->em;
	}

	/**
	 * Redirige sur la page de consultation de la collection numérique
	 *
	 * @return void
	 */
	public function indexAction()
	{
		return $this->redirect()->toRoute('collection/consulter');
	}
	
    /**
     * Création d'un média
     * 
     * On envoi à la vue la liste des types de médias possibles
     * Lorsque l'utilisateur en a choisi un, javascript dans le vue fait rappelle cette action.
     * On envoie alors à la vue la formulaire correspondant pour créer un média du type choisi
     * Lorsque le formulaire est posté, on traite la requête
     * et on créé le média avec les données remplies
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function ajouterAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
        $TEmedias = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'media'));
        $form = null;
        $type_element_id = (int) $this->params()->fromRoute('type_element_id', 0);
        if ($type_element_id) {
            // On affiche le formulaire correspondant à ce type de média
            $type_element = $this->getEntityManager()
                    ->getRepository('Collection\Entity\TypeElement')
                    ->findOneBy(array('type'=>'media', 'id'=>$type_element_id));
            if ($type_element) {
                $form = new ChampTypeElementForm($type_element);
            } else {
                echo "<script>alert(\"Erreur : Type de média non trouvé\")</script>";
                return new ViewModel(array('types' => $TEmedias, 'form' => $form, 'type_element_id'=>$type_element_id));
            }
            
            $request = $this->getRequest();
            if ($request->isPost()) {
                // On créé un nouveau média
                $media = new Media(null, $type_element);
                $form->setInputFilter($media->getInputFilter());
                $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(),
                    $this->getRequest()->getFiles()->toArray()
                );
                $form->setData($data);
                if ($form->isValid()) {
                    $media->populate($data);
                    $this->getEntityManager()->persist($media);
                    $this->getEntityManager()->flush();
                    $this->flashMessenger()->addSuccessMessage(sprintf('Le média "%1$s" a bien ete créé.', $escapeHtml($media->titre)));
                    return $this->redirect()->toRoute('media/voirMedia', array('id'=>$media->id));
                } else {
                    return new ViewModel(array('types' => $TEmedias, 'form' => $form, 'type_element_id'=>$type_element_id));
                }
            }
        }
        return new ViewModel(array('types' => $TEmedias, 'form' => $form, 'type_element_id'=>$type_element_id));
    }

    /**
     * Renvoie à la vue le média à afficher
     * 
     * Renvoie à la vue le média à afficher
     * après l'avoir cherché en base de données
     * à partir de l'id passé dans l'url
     * 
     * @return void|\Zend\View\Model\ViewModel
     */
    public function voirMediaAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        try {
            $Media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>$id));
        }
        catch (\Exception $ex) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        if ($Media==null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $ChampsDatasElement = $this->getEntityManager()
                ->getRepository('Collection\Entity\Champ')
                ->getChampsDatasElement($Media,$Media->type_element);
        //$Media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>1));
        return new ViewModel(array('media' => $Media,'ChampsDatasElement'=>$ChampsDatasElement));
    }

    /**
     * Modification d'un média existant
     * 
	 * Cette action est déclenchée par un appel AJAX lancé par X-Editable
	 * On commence par récupérer le média à modifier : 
	 * son ID est passé en paramètre dans la requête AJAX
	 * Plusieurs types de requêtes sont traitées ici, 
	 * on sait de quel type de requête il s'agit grâce à l'attribut 'name' envoyé par la vue
	 * qui peut valoir :
	 * 		'titre' : on modifie le titre du média
	 * 		'description' : on modifie la description du média
	 * 		'data' : on modifie l'une des datas du média, 
	 * 				 il faut alors regarder de quelle data il s'agit
	 * 
     * @return void|\Zend\View\Model\ViewModel
     */
    public function editMediaAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>$id));
    	if (!$id or $media === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	
    	if ($media->utilisateur != $this->zfcUserAuthentication()->getIdentity()) {
    		$this->flashMessenger()->addErrorMessage(sprintf('Le média doit faire partie de vos chantiers en cours pour que vous puissiez le modifier.'));
    		return $this->redirect()->toRoute('media/voirMedia', array('id'=>$id));
    	}
    	
        if ($this->getRequest()->isXmlHttpRequest()) 
        {
            $request = $this->params()->fromPost();
            switch ($request['name']) {
                case 'titre':
                    $media->titre = $request['value'];
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
                break;

                case 'description':
                    $media->description = $request['value'];
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
                break;
                case 'data':
                    $idData = (int) $this->params()->fromRoute('idData', 0);
                    $champData = $this->getEntityManager()->getRepository('Collection\Entity\Champ')->getChampData($media,$idData);
                    if (!$idData or $champData === null) {
                        $this->getResponse()->setStatusCode(404);
                        return;
                    }
                    if ($champData['data'] != null) {
                        $data = $champData['data'];
                    } else {
                        $champ = $this->getEntityManager()->getRepository('Collection\Entity\Champ')->findOneBy(array('id'=>$champData['id']));

                        $data = 'new';

                                
                    }
                    switch ($champData['format']) {
                        case 'texte':
                            if ($data == 'new') {
                                $data = new \Collection\Entity\DataTexte($media,$champ);
                                $media->datas->add($data);
                            }
                            $data->texte = $request['value'];
                            break;
                        case 'textarea':
                            if ($data == 'new') {
                                $data = new \Collection\Entity\DataTextarea($media,$champ);
                                $media->datas->add($data);
                            }
                            $data->textarea = $request['value'];
                            break;
                        case 'date':
                            if ($data == 'new') {
                                $data = new \Collection\Entity\DataDate($media,$champ);
                                $media->datas->add($data);
                                $data->element = $media;
                            }
                            $data->date = new \DateTime($request['value']);

                            break;
                        case 'nombre':
                            if ($data == 'new') {
                                $data = new \Collection\Entity\DataNombre($media,$champ);
                                $media->datas->add($data);
                            }
                            $data->nombre = $request['value'];
                            break;
                        case 'fichier':
                            if ($data == 'new') {
                                $data = new \Collection\Entity\DataFichier($media,$champ);
                                $media->datas->add($data);
                            }
                            $files = $this->params()->fromFiles();
                            $file = $files['file-input'];
                            if ($file != null) {
                                $media->deleteFile($data);
                                $media->updateFile($data, $file['tmp_name'], $file['name'], $file['type']);
                            }
                            break;
                        case 'url':
                            if ($data == 'new') {
                                $data = new \Collection\Entity\DataUrl($media,$champ);
                                $media->datas->add($data);
                            }
                            $data->url = $request['value'];
                            break;
                        default:
                            return $this->getResponse()->setContent(Json::encode(false));
                        break;
                    } // end switch format
                    $this->getEntityManager()->persist($data);
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
                break;
                default:
                    return $this->getResponse()->setContent(Json::encode(false));  
                break;
            } // end switch request name
        }
        $ChampsDatasElement = $this->getEntityManager()
            ->getRepository('Collection\Entity\Champ')
            ->getChampsDatasElement($media,$media->type_element);
        return new ViewModel(array('media' => $media,'ChampsDatasElement'=>$ChampsDatasElement));
    }

    /**
     * Suppression d'un média
     * 
	 * On commence par récupérer le média à supprimer :
	 * son ID est passé en paramètre dans la requête AJAX
	 * On pense bien à supprimer les éventuels fichiers uploadés pour ce média
     */
    public function removeMediaAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
    
        $media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>$id));
        
        if ($media === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

    	foreach( ($media->datas) as $data){
			if($data->fichier !== null){
				$media->deleteFile($data);
			}
		}
        
        $this->getEntityManager()->remove($media);
        $this->getEntityManager()->flush();
        $this->flashMessenger()->addSuccessMessage(sprintf('Le média a bien été supprimé.'));
        return $this->redirect()->toRoute('collection/consulter');
    }

    /**
     * Suppression d'une relation entre un média et un artefact
     * 
     * Cette action est déclenché par un appel AJAX
     * lancé depuis la modale de confirmation dans la vue.
     * Les id du média et de l'artefact à délier son pssés en
     * paramètre de la requête
     */
    public function supprimerRelationMediaArtefactAction()
    {
    	$idArtefact = (int) $this->params('idArtefact', null);
    	$idMedia = (int) $this->params('idMedia', null);
    	$artefact = $this->getEntityManager()
    			->getRepository('Collection\Entity\Artefact')
    			->findOneBy(array('id'=>$idArtefact));
    	$media = $this->getEntityManager()
    			->getRepository('Collection\Entity\Media')
    			->findOneBy(array('id'=>$idMedia));
    	if ($idMedia === null || $idArtefact === null 
    		|| $artefact === null || $media === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$artefact->medias->removeElement($media);
    	$this->getEntityManager()->flush();
    	$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été supprimée.'));
    	return $this->getResponse()->setContent(Json::encode(true));
    }
    
    /**
     * Crée la relation entre un média et un artefact
     *
     * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
     * Elle récupère l'id du artefact présent dans les paramètres de la route puis l'id
     * du média depuis les variables POST. On vérifie ensuite que tous les ids
     * sont bien présents et on vérifie que les ids correspondent à un élément en
     * base de donnée. Et enfin on ajoute la relation.
     *
     * @return void|\Zend\Stdlib\mixed
     */
    public function addRelationMediaArtefactAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {
			
			$idArtefact = (int) $this->params()->fromRoute('idArtefact', 0);
			$idMedia    = (int) $this->params()->fromPost('idMedia', 0);
			

			if (!$idMedia) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour le média'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
			
			if (!$idArtefact) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour l\'artefact'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}

			$artefact = $this->getEntityManager()
						     ->getRepository('Collection\Entity\Artefact')
						     ->findOneBy( array( 'id' => $idArtefact ));

			$media = $this->getEntityManager()
						  ->getRepository('Collection\Entity\Media')
						  ->findOneBy( array( 'id' => $idMedia ));
			
			if ( $media === null || $artefact === null ) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Une des entités est introuvable'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
			
			foreach($artefact->medias as $mediaArt){
				if($mediaArt->id === $media->id ){
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Cette relation existe déjà'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
			}

			try {
				$artefact->medias->add($media);
				$this->getEntityManager()->flush();
			} catch (Exception $e) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Erreur durant l\'insertion en base de donnée'));
				return $this->getResponse()->setContent(Json::encode( array( 'success' => false)));
			}
			$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été ajoutée.'));
			return $this->getResponse()->setContent(Json::encode( array( 'success' => true, 'message' => 'La relation a bien été ajoutée.' ) ));

		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	}
	
	/**
	 * Retourne une liste de tous les artefacts à la Datatable
	 *
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle prend en paramètre les conditions renvoyées par le widget Datatable et précisés
	 * au moment de l'instanciation du widget. Ces paramètres sont ensuite envoyé à la classe
	 * Datatable qui se charge de renvoyer les données récupérées en base de donnée. Ces données
	 * sont ensuite passées à la Datatable qui se chargera de les afficher.
	 *
	 */
    public function getAllArtefactAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
    	$params = null;
	
		if ($this->getRequest()->isXmlHttpRequest()) {
			
			$params = $this->params()->fromPost();

			if(!isset($params["iSortCol_0"])){
				$params["iSortCol_0"] = '0';
			}
			 
			if(!isset($params["sSortDir_0"])){
				$params["sSortDir_0"] = 'ASC';
			}
	
			$entityManager = $this->getEntityManager()
							      ->getRepository('Collection\Entity\Element');
			 
			$dataTable = new \Collection\Model\ElementDataTable($params);
			$dataTable->setEntityManager($entityManager);
			 
			$dataTable->setConfiguration(array(
					'titre',
					'type'
			));
			 
			$aaData = array();
	
			$paginator = null;
	
			if(isset($params["conditions"])){
				$conditions = json_decode($params["conditions"], true);
				$paginator = $dataTable->getPaginator($conditions);
			} else {
				$paginator = $dataTable->getPaginator();
			}
			 
			foreach ($paginator as $element) {
	
				$titre = '';
				if($element->type_element->type == 'artefact'){
					$titre = '<p class="text-success"><i class="icon-tag"> </i><a class="href-type-element text-success" href="'.$this->url()->fromRoute('artefact/voirArtefact', array('id' => $element->id)).'">'.$escapeHtml($element->titre).'</a></p>';
				} elseif($element->type_element->type == 'media'){
					$titre = '<p class="text-warning"><i class="icon-picture"> </i><a class="href-type-element text-warning" href="'.$this->url()->fromRoute('media/voirMedia', array('id' => $element->id)).'">'.$escapeHtml($element->titre).'</a></p>';
				} else {
					$titre = $escapeHtml($element->titre);
				}
	
				$bouton = '<a href="#" class="btn btn-primary ajouter" data-url="'.$this->url()->fromRoute('media/addRelationMediaArtefact', array('idArtefact' => $element->id)).'"><i class="icon-plus"></i> Lier </a>';
	
				$aaData[] = array(
						$titre,
						$element->type_element->nom,
						$bouton
				);
			}
	
			$dataTable->setAaData($aaData);
	
			return $this->getResponse()->setContent($dataTable->findAll());
		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	}
}
