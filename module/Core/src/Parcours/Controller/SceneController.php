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

class SceneController extends AbstractActionController
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
		return new ViewModel(array(
			'scene' => $Scene
		));
    }

    public function removeSceneAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$id));
		if ($scene === null or $id === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		$tr_before = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_destination'=>$id));
		$tr_after = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_origine'=>$id));

		if($tr_before === null && $tr_after === null) // c'est la seule
		{
			$this->flashMessenger()->addErrorMessage(sprintf('Impossible de supprimer la dernière scène de ce parcours.'));
			return $this->redirect()->toRoute('scene/voirScene', array('id' => $scene->id));
		}
		elseif($tr_before === null) // c'est la première
		{
			$scene->sous_parcours->scene_depart = $tr_after->scene_destination;
			$this->getEntityManager()->remove($tr_after);
		}
		elseif($tr_after === null)// c'est la dernière
		{
			$this->getEntityManager()->remove($tr_before);
		}
		else // elle est au milieu
		{
			$tr_after->scene_origine = $tr_before->scene_origine;
			$this->getEntityManager()->remove($tr_before);
		}

		$this->getEntityManager()->remove($scene);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('La scène a bien été supprimée.'));
		return $this->redirect()->toRoute('parcours');
	}

	/**
	 * Ajout d'une scène à un parcours
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
		$newScene->narration = 'Narration';
		$scene->sous_parcours->addScene($newScene);
		$newTransitionRecommandee = new TransitionRecommandee();
		$newTransitionRecommandee->narration = 'Nouvelle Transition';
		$scene->sous_parcours->addTransition($newTransitionRecommandee);
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
        			$newTransitionRecommandee->scene_origine = $newScene;
        			$newTransitionRecommandee->scene_destination = $scene;
        		} else { 
        			// Ce n'est pas la première : on doit insérer $newScene entre $sceneBefore et $scene
        			$sceneBefore = $tr_before->scene_origine;
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
		return new ViewModel(array('scene' => $scene));
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
}