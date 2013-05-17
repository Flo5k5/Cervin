<?php
namespace Core;

use Collection\View\Helper\formatForm;
use Collection\View\Helper\DatatableWidget;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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
                'DatatableWidget' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new DatatableWidget();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
            ),
        );
    }
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    'Collection' => __DIR__ . '/src/Collection',
                    'Parcours' => __DIR__ . '/src/Parcours'
                ),
            ),
        );
    }
}
