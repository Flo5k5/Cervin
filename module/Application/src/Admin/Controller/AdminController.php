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
use SamUser\Entity\Role;
use Zend\Mvc\Controller\Plugin\Url;

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
                  //  '<span class="label label-important">'.$user->roles['0']->getRoleId().'</span>',
                    '<a href="#" id="role" class="status" data-type="select" data-pk="1" data-url="'.$this->url()->fromRoute("admin/changeRole", array("id" => $user->id)).'" data-value="'.$user->roles['0']->getId().'">'.$user->roles['0']->getRoleId().'</a>',
                    '<a href="#" class="btn"><i class="icon-trash"></i> Supprimer</a>'
                    ,
                );
            }
            $dataTable->setAaData($aaData);
            
            return $this->getResponse()->setContent($dataTable->findAll());
        } else {
            
            
            return new ViewModel(array(
                'roles' => $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findAll()
            ));

        }
    }

    public function changeRoleAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
        
            $postData = $this->params()->fromPost();

            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('admin/changeRole');
            }

            try {
                $user = $this->getEntityManager()->find('SamUser\Entity\User', $id);
                $role = $this->getEntityManager()->find('SamUser\Entity\Role', $postData['value']);
            }
            catch (\Exception $ex) {
                return $this->redirect()->toRoute('home');
            }
            $user->removeRoles($user->getRoles());
            $user->addRole($role);

            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();


            $entityManager = $this->getEntityManager()->getRepository('SamUser\Entity\Role');
            $this->getRequest()->getPost('value');
            
            return true;
        } else {
            return $this->redirect()->toRoute('home');
        }
    }
}
