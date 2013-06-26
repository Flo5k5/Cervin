<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Collection\Form\ChampTypeElementForm;
use Zend\Form\Form;
use Zend\Form\Element;
use Exception;
use Collection\Entity\Artefact;
use Collection\Entity\Data;
use Collection\Entity\RelationArtefacts;
use Zend\File\Transfer\Adapter\Http;
use Zend\Json\Json;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

/**
 * Controleur des artefacts
 * 
 * Permet la création, lecture, modification et suppression d'un artefact
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class ArtefactController extends AbstractActionController
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
     * Création d'un artefact
     * 
     * On envoi à la vue la liste des types d'artefacts possibles
     * Lorsque l'utilisateur en a choisi un, javascript dans le vue fait rappelle cette action.
     * On envoie alors à la vue la formulaire correspondant pour créer un artefact du type choisi
     * Lorsque le formulaire est posté, on traite la requête 
     * et on créé l'artefact avec les données remplies
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function ajouterAction()
    {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
    	$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'));
    	$form = null;
    	$type_element_id = (int) $this->params()->fromRoute('type_element_id', 0);
    	if ($type_element_id) {
    		// Un type d'artefact a été choisi dans le select
    		// On affiche le formulaire correspondant à ce type d'artefact
    		$type_element = $this->getEntityManager()
    				->getRepository('Collection\Entity\TypeElement')
    				->findOneBy(array('type'=>'artefact', 'id'=>$type_element_id));
    		if ($type_element) {
    			$form = new ChampTypeElementForm($type_element);
    		} else {
    			echo "<script>alert(\"Erreur : Type d'artefact non trouvé\")</script>";
    			return new ViewModel(array('types' => $TEartefacts, 'form' => $form, 'type_element_id'=>$type_element_id));
    		}
    		$request = $this->getRequest();
    		if ($request->isPost()) {
    			// Le formulaire a été posté
    			// On créé le nouvel artefact
    			$artefact = new Artefact(null, $type_element);
    			$form->setInputFilter($artefact->getInputFilter());
    			$data = array_merge_recursive(
    				$this->getRequest()->getPost()->toArray(),
    				$this->getRequest()->getFiles()->toArray()
    			);
    			$form->setData($data);
    			if ($form->isValid()) {
    				$artefact->populate($data);
    				$this->getEntityManager()->persist($artefact);
    				$this->getEntityManager()->flush();
    				$this->flashMessenger()->addSuccessMessage(sprintf('L\'artefact "%1$s" a bien ete créé.', $escapeHtml($artefact->titre)));
    				return $this->redirect()->toRoute('artefact/voirArtefact', array('id'=>$artefact->id));
    			} else {
    				return new ViewModel(array('types' => $TEartefacts, 'form' => $form, 'type_element_id'=>$type_element_id));
    			}
    		}
    	}
    	return new ViewModel(array('types' => $TEartefacts, 'form' => $form, 'type_element_id'=>$type_element_id));
    }

    /**
     * Renvoie à la vue l'artefact à afficher
     * 
     * Renvoie à la vue l'artefact à afficher
     * après l'avoir cherché en base de données
     * à partir de l'id passé dans l'url
     * 
     * @return void|\Zend\View\Model\ViewModel
     */
	public function voirArtefactAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->getResponse()->setStatusCode(404);
            return;
		}
		try {
			$Artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>$id));
		}
		catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
            return;
		}
		if($Artefact==null){
			$this->getResponse()->setStatusCode(404);
            return;
		}

		$ChampsDatasElement = $this->getEntityManager()
				->getRepository('Collection\Entity\Champ')
				->getChampsDatasElement($Artefact,$Artefact->type_element);

		$relations_out = $this->getEntityManager()
				->getRepository('Collection\Entity\RelationArtefacts')
				->findBy(array('origine'=>$Artefact));
		$relations_in = $this->getEntityManager()
				->getRepository('Collection\Entity\RelationArtefacts')
				->findBy(array('destination'=>$Artefact));
		return new ViewModel(array(
			'artefact' => $Artefact, 
			'ChampsDatasElement' => $ChampsDatasElement,
			'relations_out'=>$relations_out, 
			'relations_in'=>$relations_in
			));
	}
	
	/**
	 * Modification d'un artefact existant
	 * 
	 * Cette action est déclenchée par un appel AJAX lancé par X-Editable
	 * On commence par récupérer l'artefact à modifier : 
	 * son ID est passé en paramètre dans la requête AJAX
	 * Plusieurs types de requêtes sont traitées ici, 
	 * on sait de quel type de requête il s'agit grâce à l'attribut 'name' envoyé par la vue
	 * qui peut valoir :
	 * 		'titre' : on modifie le titre de l'artefact
	 * 		'description' : on modifie la description de l'artefact
	 * 		'data' : on modifie l'une des datas de l'artefact, 
	 * 				 il faut alors regarder de quelle data il s'agit
	 * 
	 * @return void|\Zend\View\Model\ViewModel
	 */
	public function editArtefactAction()
	{
		$id       = (int) $this->params()->fromRoute('id', 0);
		$artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>$id));
		
		if (!$id or $artefact === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        if ($artefact->utilisateur != $this->zfcUserAuthentication()->getIdentity()) {
        	$this->flashMessenger()->addErrorMessage(sprintf('L\'artefact doit faire partie de vos chantiers en cours pour que vous puissiez le modifier.'));
        	return $this->redirect()->toRoute('artefact/voirArtefact', array('id'=>$id));
        }
        
		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				case 'titre':
					$artefact->titre = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;

				case 'description':
					$artefact->description = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;

				case 'data':
					$idData = (int) $this->params()->fromRoute('idData', 0);
					$champData = $this->getEntityManager()->getRepository('Collection\Entity\Champ')->getChampData($artefact,$idData);
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
			    	 			$data = new \Collection\Entity\DataTexte($artefact,$champ);
			    	 			$artefact->datas->add($data);
			    	 		}
		    	 			$data->texte = $request['value'];
		    	 			break;
		    	 		case 'textarea':
			    	 		if ($data == 'new') {
			    	 			$data = new \Collection\Entity\DataTextarea($artefact,$champ);
			    	 			$artefact->datas->add($data);
			    	 		}
		    	 			$data->textarea = $request['value'];
		    	 			break;
		    	 		case 'date':
			    	 		if ($data == 'new') {
			    	 			$data = new \Collection\Entity\DataDate($artefact,$champ);
			    	 			$artefact->datas->add($data);
			    	 			$data->element = $artefact;
			    	 		}
		    	 			$data->date = new \DateTime($request['value']);

		    	 			break;
		    	 		case 'nombre':
			    	 		if ($data == 'new') {
			    	 			$data = new \Collection\Entity\DataNombre($artefact,$champ);
			    	 			$artefact->datas->add($data);
			    	 		}
		    	 			$data->nombre = $request['value'];
		    	 			break;
		    	 		case 'fichier':
			    	 		if ($data == 'new') {
			    	 			$data = new \Collection\Entity\DataFichier($artefact,$champ);
			    	 			$artefact->datas->add($data);
			    	 		}
		    	 			$files = $this->params()->fromFiles();
		    	 			$file = $files['file-input'];
		    	 			if ($file != null) {
			    	 			$artefact->deleteFile($data);
			    	 			$artefact->updateFile($data, $file['tmp_name'], $file['name'], $file['type']);
		    	 			}
		    	 			break;
		    	 		case 'url':
			    	 		if ($data == 'new') {
			    	 			$data = new \Collection\Entity\DataUrl($artefact,$champ);
			    	 			$artefact->datas->add($data);
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
			->getChampsDatasElement($artefact,$artefact->type_element);
		$relations_out = $this->getEntityManager()
						->getRepository('Collection\Entity\RelationArtefacts')
						->findBy(array('origine'=>$artefact));
		$relations_in = $this->getEntityManager()
						->getRepository('Collection\Entity\RelationArtefacts')
						->findBy(array('destination'=>$artefact));
		return new ViewModel(array(
				'artefact' => $artefact, 
				'ChampsDatasElement' => $ChampsDatasElement,
				'relations_out'=>$relations_out, 
				'relations_in'=>$relations_in));
	}
	
	/**
	 * Suppression d'un artefact
	 * 
	 * On commence par récupérer l'artefact à supprimer :
	 * son ID est passé en paramètre dans la requête AJAX
	 * On pense bien à supprimer les éventuels fichiers uploadés pour cet artefact
	 */
	public function removeArtefactAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>$id));
		if ($artefact === null or $id === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		foreach( ($artefact->datas) as $data){
			if($data->fichier !== null){
				$artefact->deleteFile($data);
			}
		}
		$this->getEntityManager()->remove($artefact);
		$this->getEntityManager()->flush();
        $this->flashMessenger()->addSuccessMessage(sprintf('L\'artefact a bien été supprimé.'));
		return $this->redirect()->toRoute('collection/consulter');
	}

	/**
	 * Suppression d'une relation entre deux artefacts
	 * 
	 * Cette action est déclenchée par un appel AJAX
	 * lancé depuis la modale de confirmation dans la vue.
	 * L'id de la relation à supprimer est passé en paramètre de la requête.
	 */
	public function supprimerRelationArtefactSemantiqueAction()
	{
		$idRelation = (int) $this->params('idRelation', null);
		$relation = $this->getEntityManager()
				->getRepository('Collection\Entity\RelationArtefacts')
				->findOneBy(array('id'=>$idRelation));
		if ($idRelation === null || $relation === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$this->getEntityManager()->remove($relation);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été supprimée.'));
		return $this->getResponse()->setContent(Json::encode(true));
	}
	
	/**
	 * Crée la relation entre une sémantique et deux artefacts
	 * 
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle récupère l'id de la sémantique et de l'élément de destination présents dans 
	 * les paramètres de la route puis l'id de l'élément d'origine depuis les variables 
	 * POST. On vérifie ensuite que tous les ids sont bien présents, si l'id de la 
	 * sémantique est absent on envoie la modal sinon on vérifie que les ids 
	 * correspondent à un élément en base de donnée. Et enfin on ajoute la relation. 
	 * 
	 * @return void|\Zend\Stdlib\mixed|Ambigous <\Zend\View\Model\ViewModel, \Zend\View\Model\ViewModel>
	 */
	public function addRelationArtefactSemantiqueAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {
			
			$idSemantique = (int) $this->params()->fromPost('idSemantique', 0);

			//Si il n'y a pas de sémantique, on charge la modal
			if(!$idSemantique){
				
				$idElementDestination = (int) $this->params()->fromRoute('idDestination', 0);
				$idElementOrigine     = (int) $this->params()->fromPost('idOrigine', 0);

				if (!$idElementDestination) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant de l\'élément de destination.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
				
				if (!$idElementOrigine) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant de l\'élément d\'origine.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
				
				$elementDestination = $this->getEntityManager()->find('Collection\Entity\Element', $idElementDestination);
				$elementOrigine     = $this->getEntityManager()->find('Collection\Entity\Element', $idElementOrigine);

				if (null === $elementDestination || null === $elementOrigine ) {
					$this->flashMessenger()->addErrorMessage(sprintf('Entity not found'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
				
				$semantiques = $this->getEntityManager()
									->getRepository('Collection\Entity\SemantiqueArtefact')
									->findBy(array('type_origine' => $elementOrigine->type_element->id, 'type_destination' => $elementDestination->type_element->id));
				
				$viewModel   = new ViewModel(
						array(
								'semantiques'   => $semantiques,
								'idOrigine'     => $idElementOrigine,
								'idDestination' => $idElementDestination,
								'titreOrigine' => $elementOrigine->titre,
								'titreDestination' => $elementDestination->titre
						)
				);
				
				$viewModel->setTerminal(true);
				return $viewModel->setTemplate('Collection/Artefact/addSemantiqueModal.phtml');

			//Si la sémantique est présente en paramétre, on crée la relation et la persiste
			} else {
				
				$idElementDestination = (int) $this->params()->fromRoute('idDestination', 0);
				$idElementOrigine     = (int) $this->params()->fromRoute('idOrigine', 0);

				if (!$idElementDestination) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant de l\'élément de destination.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
				
				if (!$idElementOrigine) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant de l\'élément d\'origine.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}

				$testRelationArtefacts = $this->getEntityManager()
								   	   		  ->getRepository('Collection\Entity\RelationArtefacts')
								              ->findOneBy( array( 'origine' => $idElementOrigine, 'destination' => $idElementDestination, 'semantique' => $idSemantique ));
				
				if( $testRelationArtefacts != null ){
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Cette relation existe déjà.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
				
				$elementOrigine = $this->getEntityManager()
								   	   ->getRepository('Collection\Entity\Element')
								       ->findOneBy( array( 'id' => $idElementOrigine ));

				$elementDestination = $this->getEntityManager()
								           ->getRepository('Collection\Entity\Element')
								           ->findOneBy( array( 'id' => $idElementDestination ));

				$semantique = $this->getEntityManager()
								   ->getRepository('Collection\Entity\SemantiqueArtefact')
								   ->findOneBy( array( 'id' => $idSemantique ));
				
				if ( $elementOrigine === null || $elementDestination === null || $semantique === null ) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Une des entités est introuvable.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}

				try {
					$relationArtefacts = new RelationArtefacts($elementOrigine, $elementDestination, $semantique);
					$this->getEntityManager()->persist($relationArtefacts);
					$this->getEntityManager()->flush();
				} catch (Exception $e) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Erreur durant l\'insertion en base de donnée.'));
					return $this->getResponse()->setContent(Json::encode( array( 'success' => false) ));
				}
				$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été ajoutée.'));
				return $this->getResponse()->setContent(Json::encode( array( 'success' => true) ));
			}
			
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
		$params = null;
	
		if ($this->getRequest()->isXmlHttpRequest()) {
			
			$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
			$escapeHtml        = $viewHelperManager->get('escapeHtml');
			
			$params            = $this->params()->fromPost();
	
			 
			if(!isset($params["iSortCol_0"])){
				$params["iSortCol_0"] = '0';
			}
			 
			if(!isset($params["sSortDir_0"])){
				$params["sSortDir_0"] = 'ASC';
			}
	
			$entityManager = $this->getEntityManager()
			                      ->getRepository('Collection\Entity\Element');
			 
			$dataTable     = new \Collection\Model\ElementDataTable($params);
			$dataTable->setEntityManager($entityManager);
			 
			$dataTable->setConfiguration(array(
					'titre',
					'type'
			));
			 
			$aaData = array();
	
			$paginator = null;
	
			if(isset($params["conditions"])){
				$conditions = json_decode($params["conditions"], true);
				$paginator  = $dataTable->getPaginator($conditions);
			} else {
				$paginator  = $dataTable->getPaginator();
			}
			 
			foreach ($paginator as $element) {
	
				$titre     = '';
				if($element->type_element->type == 'artefact'){
					$titre = '<p class="text-success"><i class="icon-tag"> </i><a class="href-type-element text-success" href="'.$this->url()->fromRoute('artefact/voirArtefact', array('id' => $element->id)).'">'.$escapeHtml($element->titre).'</a></p>';
				} elseif($element->type_element->type == 'media'){
					$titre = '<p class="text-warning"><i class="icon-picture"> </i><a class="href-type-element text-warning" href="'.$this->url()->fromRoute('media/voirMedia', array('id' => $element->id)).'">'.$escapeHtml($element->titre).'</a></p>';
				} else {
					$titre = $escapeHtml($element->titre);
				}
	
				$bouton    = '<a href="#" class="btn btn-primary ajouter" data-url="'.$this->url()->fromRoute('artefact/addRelationArtefactSemantique', array('idDestination' => $element->id)).'"><i class="icon-plus"></i> Lier </a>';
	
				$aaData[]  = array(
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
	
	/**
	 * Crée la relation entre un artefact et un media
	 * 
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle récupère l'id du media présent dans les paramètres de la route puis l'id 
	 * de l'artefact depuis les variables POST. On vérifie ensuite que tous les ids 
	 * sont bien présents et on vérifie que les ids correspondent à un élément en 
	 * base de donnée. Et enfin on ajoute la relation. 
	 * 
	 * @return void|\Zend\Stdlib\mixed
	 */
	public function addRelationArtefactMediaAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {

			$idMedia    = (int) $this->params()->fromRoute('idMedia', 0);
			$idArtefact = (int) $this->params()->fromPost('idArtefact', 0);
	
			if (!$idMedia) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour le média.'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
				
			if (!$idArtefact) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour l\'artefact.'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
	
			$artefact = $this->getEntityManager()
			->getRepository('Collection\Entity\Artefact')
			->findOneBy( array( 'id' => $idArtefact ));
	
			$media = $this->getEntityManager()
			->getRepository('Collection\Entity\Media')
			->findOneBy( array( 'id' => $idMedia ));
				
			if ( $media === null || $artefact === null ) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Une des entités est introuvable.'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false, 'error' => 'Une des entités est introuvable' )));
			}
				
			foreach($artefact->medias as $mediaArt){
				if($mediaArt->id === $media->id ){
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Cette relation existe déjà.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
			}
	
			try {
				$artefact->medias->add($media);
				$this->getEntityManager()->flush();
			} catch (Exception $e) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Erreur durant l\'insertion en base de donnée.'));
				return $this->getResponse()->setContent(Json::encode( array( 'success' => false, 'error' => 'Erreur durant l\'insertion en base de donnée' ) ));
			}
			$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été ajoutée.'));
			return $this->getResponse()->setContent(Json::encode( array( 'success' => true)));
	
		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	}
	
	/**
	 * Retourne une liste de tous les medias à la Datatable
	 *
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle prend en paramètre les conditions renvoyées par le widget Datatable et précisés
	 * au moment de l'instanciation du widget. Ces paramètres sont ensuite envoyé à la classe
	 * Datatable qui se charge de renvoyer les données récupérées en base de donnée. Ces données
	 * sont ensuite passées à la Datatable qui se chargera de les afficher.
	 *
	 */
	public function getAllMediaAction()
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
					$titre = '<p class="text-success"><i class="icon-tag"> </i><a class="href-type-element text-success" href="'.$this->url()->fromRoute('artefact/voirArtefact', array('id' => $element->id)).'">'.$escapeHtml($element->titre).'</a></p>';
				} elseif($element->type_element->type == 'media'){
					$titre = '<p class="text-warning"><i class="icon-picture"> </i><a class="href-type-element text-warning" href="'.$this->url()->fromRoute('media/voirMedia', array('id' => $element->id)).'">'.$escapeHtml($element->titre).'</a></p>';
				} else {
					$titre = $escapeHtml($element->titre);
				}
	
				$bouton = '<a href="#" class="btn btn-primary ajouter" data-url="'.$this->url()->fromRoute('artefact/addRelationArtefactMedia', array('idMedia' => $element->id)).'"><i class="icon-plus"></i> Lier </a>';
	
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
