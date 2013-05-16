<?php
namespace Collection\View\Helper;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 
class CollectionWidget extends AbstractHelper
{
	protected $em;
	protected $serviceLocator;

    public function setServiceLocator(ServiceManager $serviceLocator) 
    { 
        $this->serviceLocator = $serviceLocator; 
    } 
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
    public function getEntityManager()
    {
        if ($this->em === null) {
            $this->em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

 
    public function __invoke($params = null)
    {
    	/*$entityManager = $this->getEntityManager()
    	->getRepository('Collection\Entity\Element');
    	
    	$dataTable = new \Collection\Model\ElementDataTable($params);
    	$dataTable->setEntityManager($entityManager);
    	
    	$dataTable->setConfiguration(array(
    			'titre',
    			'description',
    			'type',
    			'artefact_media'
    	));
    	
    	$aaData = array();
    	 
    	$paginator = null;

    	if(isset($params["conditions"])){
    		$paginator = $dataTable->getPaginator($params["conditions"]);
    	} else {
    		$paginator = $dataTable->getPaginator();
    	}
    	
    	foreach ($paginator as $element) {
    		$aaData[] = array(
    				$element->titre,
    				$element->description,
    				$element->type_element->nom,
    				$element->type_element->type
    		);
    	}
    	 
    	$dataTable->setAaData($aaData);*/

    	//return $this->getResponse()->setContent($dataTable->findAll());

    	//return $dataTable->getJSONaaData();
    	$js_table = null;
    	
    	if(isset($params)){
    		foreach ($params as $param){
    			$js_table .= ' data.push('.json_encode($param, JSON_FORCE_OBJECT).'); ';
    		}
    	}
    	
        return $this->getView()->partial('Collection/Collection/CollectionWidget.phtml', array(  
            'js_table' => $js_table, 
        ));
    }
}