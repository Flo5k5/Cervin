<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\Adapter\Adapter;

use SamUser\Entity\User;

use Doctrine\ORM\EntityManager;

use Zend\ModuleManager\Feature\ServiceProviderInterface;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
//
class Module implements AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $events = $e->getApplication()->getEventManager()->getSharedManager();
        $events->attach('ZfcUser\Form\Register','init', function($e) {
            $form = $e->getTarget();
            
            $form->get('display_name')->setLabel('Nom / prénom');
            $form->get('username')->setLabel('Login');
            $form->get('password')->setLabel('Mot de passe');
            $form->get('passwordVerify')->setLabel('Vérification mot de passe');
            $form->get('submit')->setLabel('Valider');
        });
        $events->attach('ZfcUser\Form\Login','init', function($e) {
            $form = $e->getTarget();
            
            $form->get('identity')->setLabel('Login');
            $form->get('credential')->setLabel('Mot de passe');
            $form->get('submit')->setLabel('Valider');
        });
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
