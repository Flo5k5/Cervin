<?php
// ./module/Application/src/Application/View/Helper/AbsoluteUrl.php
namespace Application\View\Helper;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;

use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 
class adminEmail extends AbstractHelper
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

        $users =$this->getEntityManager()->getRepository('SamUser\Entity\User')->findAll();

        $adminEmailList = '';
        foreach($users as $user)
        {
            if($user->roles['0']->getRoleId() == 'Admin')
            {
                $adminEmailList .= $user->getEmail().";";
            }
        }
        
    return $adminEmailList;
    }
}