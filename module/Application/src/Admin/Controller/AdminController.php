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
use Zend\Json\Json;
use Admin\Form\UserForm;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;

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
        return $this->redirect()->toRoute('page');
    }
    ///////////////////////////////////////////////////////////////////////////
    
    /**
     * Affiche le tableau de gestion des utilisateurs
     **/
    public function editusersAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
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
	            
                if($user->attenteRole === null )
                {
                    $attenteRole = '';
                    $attenteRoleDataOriginalTitle = '';
                } else {
                    $attenteRole = '<span class="text-error">
                                    <i class="icon-comment"></i></span>
                                    ';
 $attenteRoleDataOriginalTitle = ' data-html="true" data-original-title="Demande le droit :<b>
 '.$user->attenteRole->getRoleId().'</b>  
 <a href=\'#\' class=\'refueRole btn btn-mini btn-danger\' data-url=\''.$this->url()->fromRoute("admin/refueRole", array("id" => $user->id)).'\'><i class=\'icon-remove\'></i> Refuser</a>"';

                }
				
				$editable_role      = "";
	            $btn_reset_password = "";
	            $btn_supprimer      = "";
				
	            if ($user->id != $this->zfcUserAuthentication()->getIdentity()->getId()) {
	            	$editable_role = '<span
	                        id="role"
	                        class="status CursorPointer"
	                        data-type="select"
	                        data-pk="'. $user->id.'"
	                        '.$attenteRoleDataOriginalTitle.'
	                        data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'"
	                        data-value="'.$roleId.'">
	                            '.$role.' '.$attenteRole.'
	                    	</span>';
	            	$btn_supprimer = '<a href="#" 
	            			data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	            			data-value="'.$user->username.'" 
	            			class="btn btn-danger SupprimerUser">
	            				<i class="icon-trash"></i> Supprimer
	            			</a>';
	            	$btn_reset_password = '<a href="#" 
	            			data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	            			data-value="'.$user->username.'" 
	            			class="btn btn-primary ResetPassword"
	            			data-toggle="popover"
	            			data-content="Un nouveau mot de passe sera généré et envoyé par mail"
	            			data-title="Réinitialiser le mot de passe de l\'utilisateur">
	            				<i class="icon-unlock"></i>
	            			</a>';
	            } else {
	            	$editable_role = ' <span id="role" > '.$role.' </span> ';
	            }
	            
                $aaData[] = array(
                    '<span id="username" 
                        class="text CursorPointer" 
                        data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
                        data-value="'.$escapeHtml($user->username).'" data-placement="right" data-type="text" data-pk="1">'.$escapeHtml($user->username).'
                    </span>',
                    '<span id="displayName" 
                        class="text CursorPointer" 
                        data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
                        data-value="'.$escapeHtml($user->displayName).'" data-type="text" data-pk="1">'.$escapeHtml($user->displayName).'
                    </span>',
                    '<span id="email" 
                        class="text CursorPointer" 
                        data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
                        data-value="'.$escapeHtml($user->email).'" data-type="text" data-pk="1">'.$escapeHtml($user->email).'
                    </span>',
                    $editable_role,
                	$btn_reset_password.$btn_supprimer
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
    
    /**
     * Permets de modifier les informations des utilisateurs via Ajax
     **/
    public function changeUserAjaxAction()
    {
        if ($this->getRequest()->isXmlHttpRequest())
        {
        
            $postData = $this->params()->fromPost();

            $id = (int) $this->params()->fromRoute('id', 0);
            
            if (!$id) {
                //return $this->redirect()->toRoute('');
                return $this->getResponse()->setContent(Json::encode(array( "success" => false, "error" => "Pas d'id spécifié en paramètre")));
            }
            
			$user = null;
			
            try {
                $user = $this->getEntityManager()->find('SamUser\Entity\User', $id);
            }
            catch (\Exception $ex) {
                //return $this->redirect()->toRoute('');
                return $this->getResponse()->setContent(Json::encode(array( "success" => false, "error" => "Impossible de trouver l'utilisateur")));
            }

            if ($postData['name'] == 'username')
            {

            	try {
            		$user->setUsername($postData['value']);
               		$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "success" => false, "error" => "Une erreur est survenue")));
            	}

                return $this->getResponse()->setContent(Json::encode(array( "success" => true, "message" => "Le login a été mis à jour")));

            }
            elseif ($postData['name'] == 'displayName')
            {

            	try {
            		$user->setDisplayName($postData['value']);
            		$this->getEntityManager()->persist($user);
            		$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "success" => false, "error" => "Une erreur est survenue")));
            	}

                return $this->getResponse()->setContent(Json::encode(array( "success" => true, "message" => "Le nom d'utilisateur a été mis à jour")));

            }
            elseif ($postData['name'] == 'email')
            {
            	try {
            		$user->setEmail($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "success" => false, "error" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "success" => true, "message" => "L'email a été mis à jour")));

            } 
            elseif ($postData['name'] == 'password')
            {
            	try {
            		$bcrypt = new Bcrypt;
	            	$bcrypt->setCost(14);
	            	
	            	//On génère un mot de passe aléatoire
	            	$password = $this->getEntityManager()->getRepository('SamUser\Entity\User')->generateRandomPassword();
	            	
	            	//On hash le mot de passe avec bcrypt puis on l'enregistre
	            	$user->setPassword( $bcrypt->create( $password ) );
	
	            	//On persiste les données en base de donnée
	                $this->getEntityManager()->persist($user);
	                $this->getEntityManager()->flush();
	                
	                //var_dump($password);
	                //var_dump($user->getPassword());
	
	                //On envoie un mail contenant le nouveau mot de passe
	                $message = new Message();
	                $message->addTo( $user->getEmail() )
			                ->addFrom('no-reply@cervin.org')
			                ->setSubject('Mot de passe réinitialisé')
			                ->setBody("Bonjour,\r\n\r\n Votre mot de passe a été réinitialisé. \r\n Votre nouveau mot de passe est ".$password." . \r\n\r\n Bonne journée! ")
			                ->setEncoding("UTF-8");
	                
	                $transport = new SendmailTransport();
	                $transport->send($message);
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "success" => false, "error" => "Une erreur est survenue")));
            	}

                return $this->getResponse()->setContent(Json::encode(array( "success" => true, "message" => "Le mot de passe a été réinitialisé")));

            } 
            elseif ($postData['name'] == 'role')
            {

                try {
                    $role = $this->getEntityManager()->find('SamUser\Entity\Role', $postData['value']);
                }
                catch (\Exception $ex) {
                    //return $this->redirect()->toRoute('');
                	return $this->getResponse()->setContent(Json::encode(array( "success" => false, "error" => "Impossible de trouver le role")));
                }
                
                if($user->attenteRole != null ){
                    $user->setAttenteRole(null);
                }
                
                $user->removeRoles($user->getRoles());
                $user->addRole($role);

                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();


                $entityManager = $this->getEntityManager()->getRepository('SamUser\Entity\Role');
                $this->getRequest()->getPost('value');
                
                return $this->getResponse()->setContent(Json::encode(array( "success" => true, "message" => "Le role a été mis à jour")));

            }
            elseif ($postData['name'] == 'supprimer')
            {
            	try {
            		$this->getEntityManager()->remove($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		//return $this->redirect()->toRoute('page');
            		return $this->getResponse()->setContent(Json::encode(array( "success" => false, "error" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "success" => true, "message" => "L'utilisateur a été supprimé")));

            }
           
        } else {
            $this->getResponse()->setStatusCode(404);
			return;
        }
    }
    
    /**
     * Droit : Utilisateur
     * Set AttenteRole avec la valeur du role demandee
     **/
    public function demandeRoleAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        try {
            $role = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findOneBy(array('id'=>$id));
            $user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$this->zfcUserAuthentication()->getIdentity()->getId()));
        
        }
        catch (\Exception $ex) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        if($role === null and $user === null){
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $this->flashMessenger()->addSuccessMessage(sprintf('La demande de droits "%1$s" a bien été prise en compte.', $role->getRoleId()));

        $user->setAttenteRole($role);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $this->redirect()->toRoute('zfcuser');


    }
    
    /**
     * Permet a l'admin de supprimer la demande de role 
     **/
    public function refueRoleAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$id));
        if($user === null){
            $this->getResponse()->setStatusCode(404);
            return;
        }
        if($user->attenteRole != null ){

            $user->setAttenteRole(null);
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            return $this->getResponse()->setContent(Json::encode(true));
        }
         return $this->getResponse()->setContent(Json::encode(false));

    }

    /**
     * Permet a l'admin de voir un journal des modifications apportées au backoffice
     **/
    public function showLogsAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');

        if ($this->getRequest()->isXmlHttpRequest()) {
            $params = $this->params()->fromQuery();
    
            $entityManager = $this->getEntityManager()
                ->getRepository('Gedmo\Loggable\Entity\LogEntry');
        
            $dataTable = new \Admin\Model\LogsDataTable($params);
            $dataTable->setEntityManager($entityManager);
            
            $dataTable->setConfiguration(array(
                'action',
                'loggedAt',
                'objectClass',
                'objectId',
                'username'
            ));

            $aaData = array();

            foreach ($dataTable->getPaginator() as $log) {
                
                $aaData[] = array(
                        $escapeHtml($log->getAction()),
                        $escapeHtml($log->getLoggedAt()->format('Y-m-d H:i:s')),
                        $escapeHtml($log->getObjectClass()),
                        $escapeHtml($log->getObjectId()),
                        $escapeHtml($log->getUsername()),
                );
            }
            $dataTable->setAaData($aaData);
            
            return $this->getResponse()->setContent($dataTable->findAll());
        } else {
            return new ViewModel();

        }
    }
    
    public function AjouterUtilisateurAction(){
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml        = $viewHelperManager->get('escapeHtml');
    	$form              = new UserForm();
    	$user              = new \SamUser\Entity\User();
    	$request           = $this->getRequest();
    	$form->bind($user);
    	
    	if ($request->isPost()) {
    	
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			
    			$username = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('username'=>$user->getUsername()));
    			$email    = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('email'=>$user->getEmail()));

    			if($username !== null || $email !== null){
    				
    				if($username !== null){ $this->flashMessenger()->addErrorMessage("Le nom d'utilisateur est déjà utilisé"); }
    				if($email    !== null){ $this->flashMessenger()->addErrorMessage("L'email est déjà utilisé"); }

    				return $this->redirect()->toRoute('admin/ajouter-utilisateur');
    			}

    			try {
    				$bcrypt = new Bcrypt;
    				$bcrypt->setCost(14);
    				
    				//On génère un mot de passe aléatoire
    				$password = $this->getEntityManager()->getRepository('SamUser\Entity\User')->generateRandomPassword();
    			
    				//On hash le mot de passe avec bcrypt puis on l'enregistre
    				$user->setPassword( $bcrypt->create( $password ) );
    			
    				//On récupère le role 'Utilisateur'
    				$role = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findOneBy(array(roleId=>'Utilisateur'));
    				
    				//Et on l'ajoute à l'utilisateur
    				$user->addRole($role);
    				
    				//On persiste les données en base de donnée
    				$this->getEntityManager()->persist($user);
    				$this->getEntityManager()->flush();
    				
    				//On envoie un mail contenant le nouveau mot de passe
    				$message = new Message();
    				$message->addTo( $user->getEmail() )
    				->addFrom('no-reply@cervin.org')
    				->setSubject('Compte CERVIN créé')
    				->setBody("Bonjour ".$user->getDisplayName().", \r\n\r\n 
Votre compte sur le site http://moving-bo.cervin.org/ a été créé. \r\n
Vos identifiants de connexion sont les suivants : \r\n\r\n 
Login : ".$user->getUsername()." \r\n
Mot de passe : ".$password." \r\n\r\n 
Bonne journée! ")
    				->setEncoding("UTF-8");
    				 
    				$transport = new SendmailTransport();
    				$transport->send($message);
    			} catch (\Exception $ex) {
    				$this->flashMessenger()->addErrorMessage("Une erreur est survenue");
    				//$this->flashMessenger()->addErrorMessage($escapeHtml($ex->getMessage()));
    				return $this->redirect()->toRoute('admin/ajouter-utilisateur');
    			}
    			
    			$this->flashMessenger()->addSuccessMessage(sprintf('L\'utilisateur %1$s a bien été créé.', $escapeHtml($user->getDisplayName())));
    			return $this->redirect()->toRoute('admin/gestion-users');
    		}
    	
    	}
    	return new ViewModel(array('form'=>$form));
    }

}
