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

class MediaController extends AbstractActionController
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Return a EntityManager
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

	public function indexAction()
    {
    	return $this->redirect()->toRoute('collection/consulter');
    }

    /**
     * Création d'un média
     * On envoi à la vue la liste des types de médias possibles
     * Lorsque l'utilisateur en a choisi un, javascript dans le vue fait rappelle cette action.
     * On envoie alors à la vue la formulaire correspondant pour créer un média du type choisi
     * Lorsque le formulaire est posté, on traite la requête
     * et on créé le média avec les données remplies
     * @return \Zend\View\Model\ViewModel
     */
    public function ajouterAction()
    {
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
                    $this->flashMessenger()->addSuccessMessage(sprintf('Le média "%1$s" a bien ete créé.', $media->titre));
                    return $this->redirect()->toRoute('collection/consulter');
                } else {
                    return new ViewModel(array('types' => $TEmedias, 'form' => $form, 'type_element_id'=>$type_element_id));
                }
            }
        }
        return new ViewModel(array('types' => $TEmedias, 'form' => $form, 'type_element_id'=>$type_element_id));
    }

    /**
     * Renvoie à la vue le média à afficher
     * après l'avoir cherché en base de données
     * à partir de l'id passé dans l'url
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
        //$Media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>1));
        return new ViewModel(array('media' => $Media));
    }

    /**
     * Modification d'un média existant
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
     * @return void|\Zend\View\Model\ViewModel
     */
    public function editMediaAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>$id));
    	$datas = $this->getEntityManager()->getRepository('Collection\Entity\Data')->findBy(array('element'=>$media));
    	if (!$id or $media === null or $datas === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
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
					$data = $this->getEntityManager()->getRepository('Collection\Entity\Data')->findOneBy(array('id'=>$idData));
					if (!idData or $data === null) {
						$this->getResponse()->setStatusCode(404);
						return;
					}
					switch ($data->champ->format) {
                        case 'texte':
                            $data->texte = $request['value'];
                            break;
                        case 'textarea':
                            $data->textarea = $request['value'];
                            break;
                        case 'date':
                            $data->date = new \DateTime($request['value']);
                            break;
                        case 'nombre':
                            $data->nombre = $request['value'];
                            break;
                        case 'fichier':
							$files = $this->params()->fromFiles();
		    	 			$file = $files['file-input'];
		    	 			if ($file != null) {
			    	 			$media->deleteFile($data);
			    	 			$media->updateFile($data, $file['tmp_name'], $file['name'], $file['type']);
		    	 			}
                        case 'url':
                            $data->url = $request['value'];
                            break;
                        default:
                            return $this->getResponse()->setContent(Json::encode(false));
                        break;
                    } // end switch format
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
                break;
                default:
                    return $this->getResponse()->setContent(Json::encode(false));  
                break;
            } // end switch request name
        }
        return new ViewModel(array('media' => $media,'datas'=>$datas));
    }

    /**
     * Suppression d'un média
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
        return $this->redirect()->toRoute('collection/consulter');
    }

    public function addRelationMediaArtefactAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {
			
			$idArtefact = (int) $this->params()->fromRoute('idArtefact', 0);
			$idMedia    = (int) $this->params()->fromPost('idMedia', 0);
			

			if (!$idMedia) {
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false, 'error' => 'Id manquant pour le média' )));
			}
			
			if (!$idArtefact) {
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false, 'error' => 'Id manquant pour l\'artefact' )));
			}

			$artefact = $this->getEntityManager()
						     ->getRepository('Collection\Entity\Artefact')
						     ->findOneBy( array( 'id' => $idArtefact ));

			$media = $this->getEntityManager()
						  ->getRepository('Collection\Entity\Media')
						  ->findOneBy( array( 'id' => $idMedia ));
			
			if ( $media === null || $artefact === null ) {
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false, 'error' => 'Une des entités est introuvable' )));
			}
			
			foreach($artefact->medias as $mediaArt){
				if($mediaArt->id === $media->id ){
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false, 'error' => 'Relation déjà présente en base de donnée' )));
				}
			}

			try {
				$artefact->medias->add($media);
				$this->getEntityManager()->flush();
			} catch (Exception $e) {
				return $this->getResponse()->setContent(Json::encode( array( 'success' => false, 'error' => 'Erreur durant l\'insertion en base de donnée' ) ));
			}

			return $this->getResponse()->setContent(Json::encode( array( 'success' => true, 'message' => 'La relation a bien été ajoutée.' ) ));

		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	}
    
    public function getAllArtefactAction()
    {
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
					$titre = '<p class="text-success"><i class="icon-tag"> </i><a class="href-type-element text-success" href="'.$this->url()->fromRoute('artefact/voirArtefact', array('id' => $element->id)).'">'.$element->titre.'</a></p>';
				} elseif($element->type_element->type == 'media'){
					$titre = '<p class="text-warning"><i class="icon-picture"> </i><a class="href-type-element text-warning" href="'.$this->url()->fromRoute('media/voirMedia', array('id' => $element->id)).'">'.$element->titre.'</a></p>';
				} else {
					$titre = $element->titre;
				}
	
				$bouton = '<a href="#" class="btn btn-info ajouter" data-url="'.$this->url()->fromRoute('media/addRelationMediaArtefact', array('idArtefact' => $element->id)).'"><i class="icon-plus"></i> Lier </a>';
	
				$aaData[] = array(
						$titre,
						$element->type_element->type,
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
