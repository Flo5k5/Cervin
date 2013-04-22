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
use Zend\Form\Annotation\AnnotationBuilder;

class CollectionController extends AbstractActionController
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
		return new ViewModel();
    }
    
    public function consulterAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		$params = $this->params()->fromQuery();
    
    		$entityManager = $this->getEntityManager()->getRepository('Collection\Entity\Element');
    
    		$dataTable = new \Collection\Model\ElementDataTable($params);
    		$dataTable->setEntityManager($entityManager);
    
    		$dataTable->setConfiguration(array(
    			'titre',
	            'description',
    			'type',
    			'artefact_media'
    		));
    
    		$aaData = array();
    
    		foreach ($dataTable->getPaginator() as $element) {
    			$aaData[] = array(
    					$element->titre,
    					$element->description,
    					$element->type_element->nom,
    					$element->type_element->type
    			);
    		}
    		$dataTable->setAaData($aaData);
    
    		return $this->getResponse()->setContent($dataTable->findAll());
    	} else {
    		return new ViewModel();
    	}
    }
    
}
