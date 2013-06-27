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
 * Controleur des elements de la collection numérique
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class ElementController extends AbstractActionController
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
    
	public function changerVisibiliteAction() {
		$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
		$escapeHtml = $viewHelperManager->get('escapeHtmlAttr');
		$id = (int) $this->params()->fromRoute('id', 0);
		$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$id));
		if (!$id or $element === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$element->public = !$element->public;
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('La visibilité de l\'élément <em>'. $escapeHtml($artefact->titre) .'</em> a bien été changée'));
		$return = $this->params()->fromRoute('return', 0);
		if ($return == 'voir') {
			if ($element instanceOf \Collection\Entity\Artefact) {
				return $this->redirect()->toRoute('artefact/voirArtefact', array('id' => $id));
			} else {
				return $this->redirect()->toRoute('media/voirMedia', array('id' => $id));
			}
		} else {
			return $this->redirect()->toRoute('collection');
		}
	}
}
