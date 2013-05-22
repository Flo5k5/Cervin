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
use Parcours\Form\SemantiqueTransitionForm;
use Parcours\Entity\SemantiqueTransition;
use Zend\Json\Json;
use Exception;

class SemantiqueTransitionController extends AbstractActionController
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
		$semantiques = $this->getEntityManager()
							->getRepository('Parcours\Entity\SemantiqueTransition')
							->findBy(array(), array('semantique'=>'asc'));
		return new ViewModel(array('semantiques'=>$semantiques));
	}

	public function ajouterAction()
	{

        $form = new SemantiqueTransitionForm();
		    
		$request = $this->getRequest();
		if ($request->isPost()) {
			$semantiqueTransition = new SemantiqueTransition();
		    $form->setInputFilter($semantiqueTransition->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$post = $request->getPost();
				$semantiqueTransition->populate($form->getData());
				$this->getEntityManager()->persist($semantiqueTransition);
			    $this->getEntityManager()->flush();
			 	$this->flashMessenger()->addSuccessMessage(sprintf('La sémantique a bien été créée.'));
	            return $this->redirect()->toRoute('semantiquetransition');
		    }
		}

		return new ViewModel(array('form'=>$form));

	}

	public function modifierAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) 
        {
			$id = (int) $this->params('id', null);
			$semantiqueTransition = $this->getEntityManager()
										->getRepository('Parcours\Entity\SemantiqueTransition')
										->findOneBy(array('id'=>$id));
			if ($semantiqueTransition === null || $id === null) {
				$this->getResponse()->setStatusCode(404);
				return;
			}
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				case 'semantique':
					$semantiqueTransition->semantique = $request['value'];
			    	$this->getEntityManager()->flush();
					break;
					
				case 'description':
					$semantiqueTransition->description = $request['value'];
					$this->getEntityManager()->flush();
					break;
			
				default:
					$this->getResponse()->setStatusCode(404);
					break;
			}
			return $this->getResponse()->setContent(Json::encode(true));
		
		} else {
			$this->getResponse()->setStatusCode(404);
		}
	}

	public function supprimerAction()
	{
		$id = (int) $this->params('id', null);
		$semantiqueTransition = $this->getEntityManager()
									->getRepository('Parcours\Entity\SemantiqueTransition')
									->findOneBy(array('id'=>$id));
		if ($semantiqueTransition === null || $id === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
        try {
			$this->getEntityManager()->remove($semantiqueTransition);
        } catch (\Doctrine_Validator_Exception $e) {
        	return $this->getResponse()->setContent(Json::encode(false));
        	//return $e->getMessage();
        }
        $this->getEntityManager()->flush();
	 	$this->flashMessenger()->addSuccessMessage(sprintf('La sémantique a bien été supprimée.'));
       	return $this->getResponse()->setContent(Json::encode(true));
	}

}
