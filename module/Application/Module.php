<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use SamUser\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\View\Helper\Notification;
use Application\View\Helper\demandeRole;
use Application\View\Helper\redirectUserIndexIfTrue;
use Zend\I18n\Translator\Translator;
use Zend\Validator\AbstractValidator;

use Gedmo\Loggable\LoggableListener as LoggableListener;

//require_once('TablePrefix.php');

class Module implements AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $cache = new \Doctrine\Common\Cache\ArrayCache;
        // standard annotation reader
        $annotationReader = new \Doctrine\Common\Annotations\AnnotationReader;

        $sm = $e->getApplication()->getServiceManager();
        $em = $sm->get('doctrine.entitymanager.orm_default');
        $evm = $em->getEventManager();

        
        //$tablePrefix = new \DoctrineExtensions\TablePrefix('mbo_');
        //$evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);
      	
      	//  $evm = new \Doctrine\Common\EventManager();
        $auth = $sm->get('zfcuser_auth_service');

        $user = ($auth->getIdentity()) ? $auth->getIdentity() : 'DEV' ;
        
        /*$loggableListener = new LoggableListener;
        //$loggableListener->setAnnotationReader($cachedAnnotationReader);
        $loggableListener->setUsername($user);
        
        $evm->addEventSubscriber($loggableListener);

        /*$translator = new Translator();
        $translator->addTranslationFile(
         'phpArray',
         './vendor/zendframework/zendframework/resources/languages/fr/Zend_Validate.php',
         'default',
         'fr_FR'
        );
        $translate = new \Zend\I18n\Translator\Translator();
        AbstractValidator::setDefaultTranslator($translator);*/
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                // the array key here is the name you will call the view helper by in your view scripts
                /*'adminEmail' => function($sm) {
                    $locator = $sm->getServiceLocator(); // $sm is the view helper manager, so we need to fetch the main service manager
                    return new adminEmail($locator->get('Doctrine\ORM\EntityManager'));
                },*/
                'Notification' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new Notification();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
                'demandeRole' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new demandeRole();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
                'flashMessages' => function($sm) {
                    $flashmessenger = $sm->getServiceLocator()
                        ->get('ControllerPluginManager')
                        ->get('flashmessenger');
 
                    $messages = new \Application\View\Helper\FlashMessages();
                    $messages->setFlashMessenger($flashmessenger);
 
                    return $messages;
                }
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'SamUser' => __DIR__ . '/src/SamUser',
                    'Admin' => __DIR__ . '/src/Admin',
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'zfcuser_user_service' => 'SamUser\Service\User2',
            ),
            'factories' => array(

            )
        );
    }
}
