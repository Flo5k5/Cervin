<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Parcours\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Parcours\Entity\SceneRecommandee;
use Parcours\Entity\TransitionRecommandee;
use Zend\Json\Json;

/**
 * Controleur des scènes
 *
 * Permet la création, lecture, modification et suppression d'une scène
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class SceneController extends AbstractActionController
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

    public function indexAction()
    {
    	return $this->redirect()->toRoute('parcours');
    }

    public function voirSceneAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->getResponse()->setStatusCode(404);
            return;
		}
		try {
			$Scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$id));
		} catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
            return;
		}
		if ($Scene==null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		try {
			$transitions_secondaires = $this->getEntityManager()
				->getRepository('Parcours\Entity\TransitionSecondaire')
				->findBy(array('scene_destination'=>$Scene));
		} catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		return new ViewModel(array(
			'scene' => $Scene,
			'transitions_secondaires' => $transitions_secondaires
		));
    }

    /**
	 * Suppression d'une scène à l'intérieur d'un parcours
	 * 
	 * Cette action est déclenchée par un appel AJAX
	 * Il faut traiter les différentes possibilités de placement de la scène
	 * afin de garder la cohérence du parcours et des transitions
	 * A noter : cette version marche tant qu'on n'a que des scènes recommandées
	 * mais il faudra la modifier pour gérer les autres types de scènes et de transitions
	 */
    public function removeSceneAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\SceneRecommandee')->findOneBy(array('id'=>$id));
		if ($scene === null or $id === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		$parcours = $scene->sous_parcours->parcours;
		$tr_before = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_destination'=>$id));
		$tr_after = $scene->transition_recommandee;

		if($tr_before === null && $tr_after === null) // c'est la seule
		{
			$this->flashMessenger()->addErrorMessage(sprintf('Impossible de supprimer la seule scène de ce parcours.'));
			return $this->redirect()->toRoute('parcours/voir', array('id' => $parcours->id));
		}
		elseif($tr_before === null) // c'est la première
		{
			// la nouvelle première est la suivante
			$scene->sous_parcours->scene_depart = $tr_after->scene_destination;
			$this->getEntityManager()->remove($tr_after);
		}
		elseif($tr_after === null)// c'est la dernière
		{
			$this->getEntityManager()->remove($tr_before);
		}
		else // elle est au milieu
		{
			//si elle est au milieu et que c'est la 1er scene d'un sous parcours
			if ($tr_before->parcours != null) {
				$tr_after->parcours = $parcours;
				$tr_after->sous_parcours = null;
				$scene->sous_parcours->scene_depart = $tr_after->scene_destination;
			}
			// rediriger la transition d'après sur la scène d'avant pour garder la cohérence
			$tr_after->scene_origine = $tr_before->scene_origine;
			$this->getEntityManager()->remove($tr_before);
		}

		$this->getEntityManager()->remove($scene);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('La scène a bien été supprimée.'));
		return $this->redirect()->toRoute('parcours/voir', array('id' => $parcours->id));
	}

	/**
	 * Ajout d'une scène à un parcours
	 * 
	 * Cette action est déclenchée par un appel AJAX
	 * Deux types de requêtes sont traitées ici, 
	 * selon si on veut ajouter une scène avant ou après une scène existante
	 * On sait de quel type de requête il s'agit grâce à l'attribut 'name' envoyé dans la requête
	 */
	public function ajouterSceneAction()
	{
		$id = (int) $this->params('id', null);
        $action = $this->params('type', null);
        if (null === $id or null === $action) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }
        $scene = $this->getEntityManager()->getRepository('Parcours\Entity\SceneRecommandee')->findOneBy(array('id'=>$id));
		if ($scene === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		// On commence par créer une nouvelle scène et une nouvelle 
		// transition recommandée dans le sous-parcours
		$newScene = new SceneRecommandee();
		$newScene->titre = 'Nouvelle scène';
		$newScene->narration = 'Narration à écrire';
		$scene->sous_parcours->addScene($newScene);
		$newTransitionRecommandee = new TransitionRecommandee();
		$newTransitionRecommandee->narration = 'Nouvelle Transition';
		$this->getEntityManager()->persist($newScene);
		$this->getEntityManager()->persist($newTransitionRecommandee);
        switch ($action) {
        	
        	case 'ajAvant': // On ajoute une scène avant $scene
        		$tr_before = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_destination'=>$scene));
        		if ($tr_before === null) { 
        			// c'est la première scène du parcours :
        			// on change la scene de depart qui est alors $newScene
        			// et $newTransitionRecommandee relie $newScene à $scene
        			$scene->sous_parcours->scene_depart = $newScene;

        			// on ajoute la transition au sous_parcours
					$scene->sous_parcours->addTransition($newTransitionRecommandee);
        			$newTransitionRecommandee->scene_origine = $newScene;
        			$newTransitionRecommandee->scene_destination = $scene;

        		} elseif($tr_before->sous_parcours == null) {
        			// Ce n'est pas la première du parcour mais la première scène du sous parcours: on doit insérer $newScene entre $sceneBefore et $scene
        			$sceneBefore = $tr_before->scene_origine;

        			// On defini cette nouvelle scène comme sene de depart.
        			$scene->sous_parcours->scene_depart = $newScene;
        			// $newTransitionRecommandee relie $sceneBefore et $newScene
        			$newTransitionRecommandee->scene_origine = $sceneBefore;
        			$newTransitionRecommandee->scene_destination = $newScene;
        			// on ajoute la transition au parcours
					$scene->sous_parcours->parcours->addTransition($newTransitionRecommandee);
        			// On ajoute la tr_before au sous parcours 
        			$tr_before->sous_parcours = $scene->sous_parcours;
        			// Et on la supprime du parcours
        			$tr_before->parcours = null;
        			// La transition qui reliait $sceneBefore et $scene ($tr_before) relie maintenant $newScene et $scene
        			$tr_before->scene_origine = $newScene;
        		} else{ 
        			// Ce n'est pas la première : on doit insérer $newScene entre $sceneBefore et $scene
        			$sceneBefore = $tr_before->scene_origine;
        			// on ajoute la transition au sous_parcours
					$scene->sous_parcours->addTransition($newTransitionRecommandee);
        			// $newTransitionRecommandee relie $sceneBefore et $newScene
        			$newTransitionRecommandee->scene_origine = $sceneBefore;
        			$newTransitionRecommandee->scene_destination = $newScene;
        			// La transition qui reliait $sceneBefore et $scene ($tr_before) relie maintenant $newScene et $scene
        			$tr_before->scene_origine = $newScene;
        		}
        		$this->getEntityManager()->flush();
        		break;
        		
        	case 'ajApres':
        		// On ajoute une scène après $scene
        		$tr_after = $scene->transition_recommandee;
        		// on ajoute la transition au sous_parcours
				$scene->sous_parcours->addTransition($newTransitionRecommandee);
        		if ($tr_after === null) {
        			// c'est la dernière scène du parcours : $newTransitionRecommandee relie $newScene à $scene
        			$newTransitionRecommandee->scene_origine = $scene;
        			$newTransitionRecommandee->scene_destination = $newScene;
        		} else {
        			// Ce n'est pas la dernière : on doit insérer $newScene entre $scene et $sceneAfter
        			$sceneAfter = $tr_after->scene_destination;
        			// $newTransitionRecommandee relie $scene et $newScene
        			$newTransitionRecommandee->scene_origine = $scene;
        			$newTransitionRecommandee->scene_destination = $newScene;
        			// La transition qui reliait $scene et $sceneAfter ($tr_after) relie maintenant $newScene et $sceneAfter
        			$tr_after->scene_origine = $newScene;
        		}
        		$this->getEntityManager()->flush();
        		break;
        		
        	default:
        		$this->getResponse()->setStatusCode(404);
        		return;
        		break;
        }

        $this->flashMessenger()->addSuccessMessage(sprintf('Une nouvelle scène a été ajoutée.'));

        return $this->redirect()->toRoute('parcours/voir', array ('id' => $scene->sous_parcours->parcours->id));
	}

	public function editSceneAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$id));
		if (!$id or $scene === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				
				case 'titre':
					$scene->titre = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;

				case 'description':
					$scene->narration = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;

			}
			return $this->getResponse()->setContent(Json::encode(true));
			
		}
		try {
			$transitions_secondaires = $this->getEntityManager()
			->getRepository('Parcours\Entity\TransitionSecondaire')
			->findBy(array('scene_destination'=>$scene));
		} catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		return new ViewModel(array(
				'scene' => $scene,
				'transitions_secondaires' => $transitions_secondaires
		));
	}

	public function deleteElementAction()
	{
		$idScene = (int) $this->params('idScene', null);
		$idElement = (int) $this->params('idElement', null);
		
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$idScene));
		$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$idElement));

		$scene->elements->removeElement($element);

		$this->getEntityManager()->flush();

		$this->flashMessenger()->addSuccessMessage(sprintf('La liaison a bien été supprimée'));
		return $this->getResponse()->setContent(Json::encode(true));
	}
	
	/**
	 * Retourne une liste de toutes les scènes à la Datatable
	 *
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle prend en paramètre les conditions renvoyées par le widget Datatable et précisés
	 * au moment de l'instanciation du widget. Ces paramètres sont ensuite envoyé à la classe
	 * Datatable qui se charge de renvoyer les données récupérées en base de donnée. Ces données
	 * sont ensuite passées à la Datatable qui se chargera de les afficher.
	 *
	 */
	public function getAllElementAction()
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
		
				$bouton = '<a href="#" class="btn btn-primary ajouter" data-url="'.$this->url()->fromRoute('scene/addRelationSceneElement', array('idElement' => $element->id)).'"><i class="icon-plus"></i> Lier </a>';
		
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
	
	/**
	 * Crée la relation entre un élément et une scène
	 * 
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle récupère l'id de l'élément présent dans les paramètres de la route puis l'id 
	 * de la scène depuis les variables POST. On vérifie ensuite que tous les ids 
	 * sont bien présents et on vérifie que les ids correspondent à un élément en 
	 * base de donnée. Et enfin on ajoute la relation. 
	 * 
	 * @return void|\Zend\Stdlib\mixed
	 */
	public function addRelationSceneElementAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {
	
			$idElement = (int) $this->params()->fromRoute('idElement', 0);
			$idScene   = (int) $this->params()->fromPost('idScene', 0);
	
			if (!$idElement) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour l\'élément.'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
	
			if (!$idScene) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour la scène.'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
	
			$element = $this->getEntityManager()
			->getRepository('Collection\Entity\Element')
			->findOneBy( array( 'id' => $idElement ));
	
			$scene = $this->getEntityManager()
			->getRepository('Parcours\Entity\Scene')
			->findOneBy( array( 'id' => $idScene ));
	
			if ( $element === null || $scene === null ) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Une des entités est introuvable.'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false, 'error' => 'Une des entités est introuvable' )));
			}

			foreach($scene->elements as $elementScene){
				if($elementScene->id === $element->id ){
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Cette relation existe déjà.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
			}
	
			try {
				$scene->elements->add($element);
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
	
}