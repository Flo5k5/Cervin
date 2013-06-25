<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Page;

class ChantierController extends AbstractActionController
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

    public function indexAction() {
        return new ViewModel();
    }

    public function demarrerChantierElementAction() {
    	$idUser = (int) $this->params()->fromRoute('idUser', 0);
    	$idElement = (int) $this->params()->fromRoute('idElement', 0);
    	$user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$idUser));
    	$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$idElement));
		if (!$idUser || !$idElement || $user == null || $element == null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$element->utilisateur = $user;
		$this->getEntityManager()->flush();
		if ($element instanceOf \Collection\ Element\Artefact) {
			$this->flashMessenger()->addEroorMessage(sprintf('L\'artefact fait maintenant partie de vos chantiers en cours.'));
			return $this->redirect()->toRoute('artefact/voirArtefact', array('id'=>$id));
    	} else {
    		$this->flashMessenger()->addEroorMessage(sprintf('Le média fait maintenant partie de vos chantiers en cours.'));
    		return $this->redirect()->toRoute('media/voirMedia', array('id'=>$id));
    	}
    }
    
}
