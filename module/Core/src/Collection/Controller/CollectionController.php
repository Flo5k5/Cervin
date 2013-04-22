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
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		$params = $this->params()->fromQuery();
    
    		$entityManager = $this->getEntityManager()
    							  ->getRepository('Collection\Entity\Element');
    							  //->createQueryBuilder('e')
    							  //->join('e.type_element', 't', 'WITH', 't.type = "artefact"');
    							  //->createQuery('SELECT e FROM Collection\Entity\Element e ');
    							  //->createQuery('SELECT e FROM Element e JOIN e.type_element t WITH t.type = "artefact"');
    		
    		/*$query = $this->getEntityManager()
    		->createQuery('SELECT a
                    FROM Artefact\Model\Artefact a
                    WHERE :mediaID NOT MEMBER OF a.medias');
    		$query->setParameter('mediaID', $id);
    		$artefactsNonLies = $query->getResult();*/
    		
    		
    		$dataTable = new \Collection\Model\ElementDataTable($params);
    		$dataTable->setEntityManager($entityManager);
    
    		$dataTable->setConfiguration(array(
<<<<<<< HEAD
    				'titre',
    				'description'
=======
    			'titre',
	            'description',
    			//'type',
    			//'artefact_media'
>>>>>>> da47675b97636e013049e54fa18d291499f66364
    		));
    
    		$aaData = array();
    		
    		$conditions = array('type' => 'artefact', 'titre' => '%Jacques%');
    		
    		foreach ($dataTable->getPaginator($conditions) as $element) {
    			$aaData[] = array(
    					$element->titre,
    					$element->description
    			);
    		}
    		$dataTable->setAaData($aaData);
    
    		return $this->getResponse()->setContent($dataTable->findAll());
    	} else {
    		return new ViewModel();
    	}
    }
    
}
