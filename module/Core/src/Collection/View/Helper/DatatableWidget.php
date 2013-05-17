<?php
namespace Collection\View\Helper;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 
class DatatableWidget extends AbstractHelper
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

 
    public function __invoke($view = null, $params = null)
    {

    	$js_table = null;
    	
    	if(isset($params)){
    		foreach ($params as $param){
    			$js_table .= ' data.push('.json_encode($param, JSON_FORCE_OBJECT).'); ';
    		}
    	}
    	
    	$viewFile = null;
    	
    	if($view === "RelationArtefact"){
    		$viewFile = 'Collection/Artefact/RelationArtefactWidget.phtml';
    	} else if($view === "RelationMedia"){
    		$viewFile = 'Collection/Media/RelationMediaWidget.phtml';
    	} else {
    		$viewFile = 'Collection/Collection/CollectionWidget.phtml';
    	}
    	
    	return $this->getView()->partial( $viewFile, array(  
	    	'js_table' => $js_table, 
	    ));
    }
}