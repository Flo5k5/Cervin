<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use SamUser\Entity\User;

// use Admin\Form\ProductForm;



class AdminController extends AbstractActionController
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

    ///////////////////////////////////////////////////////////////////////////
    public function indexAction()
    {
        
    }
    ///////////////////////////////////////////////////////////////////////////
    public function editusersAction()
    {

		if ($this->getRequest()->isXmlHttpRequest()) {
            $params = $this->params()->fromQuery();
    
            $entityManager = $this->getEntityManager()
                ->getRepository('SamUser\Entity\User');
        
            $dataTable = new \Admin\Model\UserDataTable($params);
            $dataTable->setEntityManager($entityManager);
            
            $dataTable->setConfiguration(array(
                'id',
                'username',
                'displayName',
                'email',
                //'roles',
            ));

            $aaData = array();
            
            foreach ($dataTable->getPaginator() as $user) {
                
            
                $aaData[] = array(
                    $user->id,
                    $user->username,
                    $user->displayName,
                    $user->email,
                    '<span class="label label-important">'.$user->roles['0']->getRoleId().'</span>',
                    '<a href="#" class="status" data-type="select" data-pk="1" data-url="/post" data-original-title="Select status">dd</a>
'
                    ,
                );
            }
            $dataTable->setAaData($aaData);
            
            return $this->getResponse()->setContent($dataTable->findAll());
        }
    }

    public function chacheRoleAction()
    {

		if ($this->getRequest()->isXmlHttpRequest()) {
            $params = $this->params()->fromQuery();
    
            $entityManager = $this->getEntityManager()
                ->getRepository('SamUser\Entity\Role');
        


            
            return true;
        }
    }
}
