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

 
    public function __invoke()
    {
        

        return $this->getView()->partial('Collection/Collection/CollectionWidget.phtml', array(  
            'posts' => 'ee'  
        ));
    }
}