<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Collection\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Collection\Form\ChampForm;
use Doctrine\DBAL\DriverManager;

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
    
    public function testAction()
    {
    	$em = $this->getEntityManager();
    	$types_elements = $em->getRepository('Collection\Entity\TypeElement')->findAll();
    	return array('types_elements' => $types_elements);
    }
    
    public function consulterAction()
    {
    	$params = null;
<<<<<<< HEAD
=======

>>>>>>> 86dd809ff8299f215a88a341c96aeca677ff17d8
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
    					      ->getRepository('Collection\Entity\Element');
 
    	$dataTable = new \Collection\Model\ElementDataTable($params);
    	$dataTable->setEntityManager($entityManager);
    
    	$dataTable->setConfiguration(array(
    		'titre',
	        'description',
    	    'nom',
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
    		
    		$aaData[] = array(
    				$titre,
    				$dataTable->truncate($element->description, 250, ' ...', false, true),
    				$element->type_element->nom,
    				$element->type_element->type
    		);
    	}
    	
    	$dataTable->setAaData($aaData);
    
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		return $this->getResponse()->setContent($dataTable->findAll());
    	} else {
    		//var_dump($this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findAll());
    		$allTypeArtefact = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findByType('artefact');
    		$allTypeMedia = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findByType('media');
    		return new ViewModel( array( 'aaData' => $dataTable->getJSONaaData(), 'allTypeArtefact' => $allTypeArtefact, 'allTypeMedia' => $allTypeMedia, ) );
    		//return new ViewModel( array( 'aaData' => $dataTable->getJSONaaData() ) );
    	}
    }
    
}
