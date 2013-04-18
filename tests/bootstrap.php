<?php
//putenv('ZF2=../../../vendor/zendframework/zendframework/library');

chdir(dirname(__DIR__));

$loader = include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../init_autoloader.php';

/*$config = array(
		'modules' => array(
				'ZendDeveloperTools',
				'DoctrineModule',
				'DoctrineORMModule',
				'BjyAuthorize',
				'ZfcBase',
				'ZfcUser',
				'ZfcUserDoctrineORM',
				'DoctrineDataFixtureModule',
				'AssetManager',
				'Application',
				'Album',
				'Core',
				'DataTable'
		),
		'module_listener_options' => array(
				'module_paths' => array(
						'./module',
						'./vendor'
				),
				'config_glob_paths' => array('config/autoload/{,*.}{global,local}.php')
		)
);*/

return Zend\Mvc\Application::init(include __DIR__ . '/../config/application.config.php');
//Zend\Mvc\Application::init($config);

/*
chdir(dirname(__DIR__));

// if you're using composer to install zf2
include_once  __DIR__ . '/../vendor/autoload.php';
// if not using composer initialize your custom autoloading here

$configuration = include(__DIR__ . '/../config/application.config.php');
$serviceManager = new Zend\ServiceManager\ServiceManager(new Zend\Mvc\Service\ServiceManagerConfig(
	isset($configuration['service_manager']) ? $configuration['service_manager'] : array()
));
$serviceManager->setService('ApplicationConfig', $configuration);
$serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');

$moduleManager = $serviceManager->get('ModuleManager');
$moduleManager->loadModules();
$serviceManager->setAllowOverride(true);

$application = $serviceManager->get('Application');
$event = new Zend\Mvc\MvcEvent();
$event->setTarget($application);
$event->setApplication($application)
	  ->setRequest($application->getRequest())
	  ->setResponse($application->getResponse())
	  ->setRouter($serviceManager->get('Router'));

Core\Collection\ChampTest::setMvcEvent($event);*/