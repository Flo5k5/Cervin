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
        return $this->redirect()->toRoute('home');
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
                'username',
                'displayName',
                'email',
                'roleId'
            ));

            $aaData = array();
            
            
            foreach ($dataTable->getPaginator() as $user) {

            if(!isset( $user->roles['0']) )
            {
                $role = 'null';
                $roleId = null;
                
            } else {
                $role = $user->roles['0']->getRoleId();
                $roleId = $user->roles['0']->getId();
            }
            
                $aaData[] = array(
                    '<span id="username" class="text CursorPointer" data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" data-value="'.$user->username.'" data-placement="right" data-type="text" data-pk="1">'.$user->username.'</span>',
                    '<span id="displayName" class="text CursorPointer" data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" data-value="'.$user->displayName.'" data-type="text" data-pk="1">'.$user->displayName.'</span>',
                    '<span id="email" class="text CursorPointer" data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" data-value="'.$user->email.'" data-type="text" data-pk="1">'.$user->email.'</span>',
                    '<span id="role" class="status CursorPointer" data-type="select" data-pk="1" data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" data-value="'.$roleId.'">'.$role.'</span>',
                    '<a href="#" data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" data-value="'.$user->username.'" class="btn btn-danger SupprimerUser"><i class="icon-trash"></i> Supprimer</a>'
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

    public function changeUserAjaxAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) 
        {
        
            $postData = $this->params()->fromPost();

            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('home');
            }

            try {
                $user = $this->getEntityManager()->find('SamUser\Entity\User', $id);
            }
            catch (\Exception $ex) {
                return $this->redirect()->toRoute('home');
            }

            if ($postData['name'] == 'username')
            {

                $user->setUsername($postData['value']);
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
                return true;

            }
            elseif ($postData['name'] == 'displayName')
            {

                $user->setDisplayName($postData['value']);
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
                return true;

            }
            elseif ($postData['name'] == 'email')
            {

                $user->setEmail($postData['value']);
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
                return true;

            } 
            elseif ($postData['name'] == 'role')
            {

                try {
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

            }
            elseif ($postData['name'] == 'supprimer')
            {

                $this->getEntityManager()->remove($user);
                $this->getEntityManager()->flush();
                return true;

            }
           
        } else {
            return $this->redirect()->toRoute('home');
        }
    }

    public function editAccueilAction()
    {
        $request = $this->getRequest();
        $page_accueil = $this->getEntityManager()->getRepository('Application\Entity\Page')->findOneBy(array('titre'=>'Accueil'));
        if ($request->isPost())
        {
            //save new text
            $data = $this->getRequest()->getPost()->toArray();
            $text = $data["wysiwyg"];
            $page_accueil->texte = $text;
            $this->getEntityManager()->persist($page_accueil);
            $this->getEntityManager()->flush();
            return $this->redirect()->toRoute('home');
        }
        else
        {
            return new ViewModel(array('page' => $page_accueil));
        }
        
    }
}
