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
		}
		catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
            return;
		}

		if($Scene==null){
			$this->getResponse()->setStatusCode(404);
            return;
		}

		$tr_before = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_destination'=>$Scene->id));
		$tr_after = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_origine'=>$Scene->id));

		if($tr_before === null)
		{
			$sc_before = null;
		}
		else
		{
			$sc_before = $tr_before->scene_origine;
		}

		if($tr_after === null)
		{
			$sc_after = null;
		}
		else
		{
			$sc_after = $tr_after->scene_destination;
		}

		return new ViewModel(array(
			'scene' => $Scene, 
			'precedente' => $sc_before,
			'suivante' => $sc_after
		));
    }

    public function removeSceneAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$id));
		
		if ($scene === null) {
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

	public function ajouterSceneAction()
	{
		return new ViewModel();
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