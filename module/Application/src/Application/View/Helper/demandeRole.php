<?php
// ./module/Application/src/Application/View/Helper/AbsoluteUrl.php
namespace Application\View\Helper;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;

use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 
class demandeRole extends AbstractHelper
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

 
    public function __invoke($role = false)
    {
        $urlHelper = $this->view->plugin('url');

        if($role === false)
        {
            $roles = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findAll();

            $return = '
            <div class="dropdown">
              <a class="dropdown-toggle btn btn-primary" id="roles" role="button" data-toggle="dropdown" href="#"><i class="icon-plus"></i> Demande de droits <span class="caret"></span></a>
              
              <ul class="dropdown-menu" role="menu" aria-labelledby="roles">';
            foreach ($roles as $role) :


               $return .= '<li><a role="menuitem" tabindex="-1" href="'.$urlHelper("admin/demandeRole", array("id" => $role->getId())).'">'.$role->getRoleId().'</a></li>';



            endforeach;

            $return .= '
              </ul>
            </div>';






        } else {

        }
        return $return;
    }
}