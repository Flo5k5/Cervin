<?php
namespace Core;

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
}
