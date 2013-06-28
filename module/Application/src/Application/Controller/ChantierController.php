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
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtml');
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
		if ($element instanceOf \Collection\Entity\Artefact) {
			$this->flashMessenger()->addSuccessMessage(sprintf('L\'artefact <em> '. $escapeHtml($element->titre) .'</em> fait maintenant partie de vos chantiers en cours.'));
			return $this->redirect()->toRoute('artefact/editArtefact', array('id'=>$idElement));
    	} else {
    		$this->flashMessenger()->addSuccessMessage(sprintf('Le média <em> '. $escapeHtml($element->titre) .'</em> fait maintenant partie de vos chantiers en cours.'));
    		return $this->redirect()->toRoute('media/editMedia', array('id'=>$idElement));
    	}
    }
    
    public function terminerChantierElementAction() {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtml');
    	$idUser = (int) $this->params()->fromRoute('idUser', 0);
    	$idElement = (int) $this->params()->fromRoute('idElement', 0);
    	$user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$idUser));
    	$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$idElement));
    	if (!$idUser || !$idElement || $user == null || $element == null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$element->utilisateur = null;
    	$this->getEntityManager()->flush();
    	if ($element instanceOf \Collection\Entity\Artefact) {
    		$this->flashMessenger()->addSuccessMessage(sprintf('L\'artefact <em>'. $escapeHtml($element->titre) .'</em> ne fait plus partie de vos chantiers en cours.'));
    	} else {
    		$this->flashMessenger()->addSuccessMessage(sprintf('Le média <em>'. $escapeHtml($element->titre) .'</em> ne fait plus partie de vos chantiers en cours.'));
    	}
    	$return = $this->params()->fromRoute('return', 0);
    	if ($return == 'admin') {
    		return $this->redirect()->toRoute('chantier/admin');
    	} elseif ($return == 'chantier'){
    		return $this->redirect()->toRoute('chantier');
    	} else {
    		if ($element instanceOf \Collection\Entity\Artefact) {
    			return $this->redirect()->toRoute('artefact/voirArtefact', array('id'=>$idElement));
    		} else {
    			return $this->redirect()->toRoute('media/voirMedia', array('id'=>$idElement));
    		}
    	}
    }
    
    public function demarrerChantierSousParcoursAction() {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtml');
    	$idUser = (int) $this->params()->fromRoute('idUser', 0);
    	$idSousParcours = (int) $this->params()->fromRoute('idSousParcours', 0);
    	$user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$idUser));
    	$sous_parcours = $this->getEntityManager()->getRepository('Parcours\Entity\SousParcours')->findOneBy(array('id'=>$idSousParcours));
    	if (!$idUser || !$idSousParcours || $user == null || $sous_parcours == null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$sous_parcours->utilisateur = $user;
    	$this->getEntityManager()->flush();
    	$this->flashMessenger()->addSuccessMessage(sprintf('Le sous parcours <em>'. $escapeHtml($sous_parcours->titre) .'</em> du parcours <em>'. $escapeHtml($sous_parcours->parcours->titre) .'</em> fait maintenant partie de vos chantiers en cours.'));

    	$idScene = (int) $this->params()->fromRoute('idScene', 0);
    	$scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$idScene));
    	return $this->redirect()->toRoute('parcours/voir', array('id'=>$sous_parcours->parcours->id));
    }
    
    public function terminerChantierSousParcoursAction() {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtml');
    	$idUser = (int) $this->params()->fromRoute('idUser', 0);
    	$idSousParcours = (int) $this->params()->fromRoute('idSousParcours', 0);
    	$user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$idUser));
    	$sous_parcours = $this->getEntityManager()->getRepository('Parcours\Entity\SousParcours')->findOneBy(array('id'=>$idSousParcours));
    	if (!$idUser || !$idSousParcours || $user == null || $sous_parcours == null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$sous_parcours->utilisateur = null;
    	$this->getEntityManager()->flush();
    	$this->flashMessenger()->addSuccessMessage(sprintf('Le sous parcours <em>'. $escapeHtml($sous_parcours->titre) .'</em> du parcours <em>'. $escapeHtml($sous_parcours->parcours->titre) .'</em> ne fait plus partie de vos chantiers en cours.'));
    	$return = $this->params()->fromRoute('return');
    	if ($return == 'admin') {
    		return $this->redirect()->toRoute('chantier/admin');
    	} elseif ($return == 'chantier'){
    		return $this->redirect()->toRoute('chantier');
    	} else {
    		return $this->redirect()->toRoute('parcours/voir', array('id'=>$sous_parcours->parcours->id));
    	}
    }
    
    public function adminAction() {
    	$em = $this->getEntityManager();
    	$query = $em->createQuery('SELECT e FROM Collection\Entity\Element e WHERE e.utilisateur IS NOT NULL');
		$elements = $query->getResult();
		$query = $em->createQuery('SELECT s FROM Parcours\Entity\SousParcours s WHERE s.utilisateur IS NOT NULL');
		$sous_parcours = $query->getResult();
		return new ViewModel(array('elements'=>$elements, 'sous_parcours'=>$sous_parcours));
    }
    
}
