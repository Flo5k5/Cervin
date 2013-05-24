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
use Parcours\Entity\Parcours;
use Parcours\Form\ParcoursForm;

class ParcoursController extends AbstractActionController
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
    	$params = null;

    	if ($this->getRequest()->isXmlHttpRequest()) {
    		$params = $this->params()->fromPost();
    	}
    	
    	if(!isset($params["iSortCol_0"])){
    		$params["iSortCol_0"] = '0';
    	}

    	if(!isset($params["sSortDir_0"])){
    		$params["sSortDir_0"] = 'ASC';
    	}
    	
    	$entityManager = $this->getEntityManager()
    					      ->getRepository('Parcours\Entity\Parcours');
 
    	$dataTable = new \Parcours\Model\ParcoursDataTable($params);
    	$dataTable->setEntityManager($entityManager);
    
    	$dataTable->setConfiguration(array(
    		'titre',
	        'description'
    	));
    
    	$aaData = array();
    	
    	$paginator = null;
    	
    	if(isset($params["conditions"])){
    		$conditions = json_decode($params["conditions"], true);
    		$paginator = $dataTable->getPaginator($conditions);
    	} else {
    		$paginator = $dataTable->getPaginator();
    	}
    		
    	foreach ($paginator as $parcours) {
    		
    		$titre = '';
    		
			$titre = '<a class="href-type-element" href="'
							.$this->url()->fromRoute('parcours/voir', array('id' => $parcours->id)).'">'
							.$parcours->titre.'
						</a>';
    		
			//$titre = $parcours->titre;
    		
    		
    		$aaData[] = array(
    				$titre,
    				$dataTable->truncate($parcours->description, 250, ' ...', false, true)
    		);
    	}
    	
    	$dataTable->setAaData($aaData);
    
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		return $this->getResponse()->setContent($dataTable->findAll());
    	} else {
    		return new ViewModel();
    	}
    }

    public function ajouterAction()
    {
        $form = new ParcoursForm();
        $Parcours = new Parcours();
        $form->bind($Parcours);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($Parcours->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEntityManager()->persist($Parcours);
                $this->getEntityManager()->flush();
                $this->flashMessenger()->addSuccessMessage(sprintf('La Parcours ["%1$s"] a bien été créé.', $Parcours->titre));
                return $this->redirect()->toRoute('parcours/voir', array ('id' => $Parcours->id));
            }
        }
        return new ViewModel(array('form'=>$form));
    }

    public function voirAction()
    {


        $id = (int) $this->params('id', null);
        if (null === $id) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }

        $Parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
        if ($Parcours === null) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }


        return new ViewModel(array('Parcours'=>$Parcours));
    }

}
