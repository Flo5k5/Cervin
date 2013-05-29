<?php
namespace Collection\View\Helper;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 
class DatatableWidget extends AbstractHelper
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	/**
	 * @var Zend\ServiceManager\ServiceManager
	 */
	protected $serviceLocator;
	
	/**
	 * Initialisation du Service Manager
	 *
	 * @param Zend\ServiceManager\ServiceManager
	 * @return void
	 */
    public function setServiceLocator(ServiceManager $serviceLocator) 
    { 
        $this->serviceLocator = $serviceLocator; 
    }
    
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
		
    	if($view === "scene"){
    		$viewFile = 'Parcours/Scene/RelationSceneElementWidget.phtml';
    	} else if($view === "semantique"){
    		$viewFile = 'Collection/Artefact/RelationArtefactSemantiqueWidget.phtml';
    	} else if($view === "artefact"){
    		$viewFile = 'Collection/Artefact/RelationArtefactMediaWidget.phtml';
    	} else if($view === "media"){
    		$viewFile = 'Collection/Media/RelationMediaArtefactWidget.phtml';
    	} else {
    		$viewFile = 'Collection/Collection/CollectionWidget.phtml';
    	}
    	
    	return $this->getView()->partial( $viewFile, array(  
	    	'js_table' => $js_table, 
	    ));
    }
}