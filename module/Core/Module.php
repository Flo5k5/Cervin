<?php
namespace Core;

use Collection\View\Helper\formatForm;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'formatForm' => function ($form) {
                    return new formatForm($form);
                },
            ),
        );
    }

}
