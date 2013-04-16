<?php
//putenv('ZF2=../../../vendor/zendframework/zendframework/library');

chdir(dirname(__DIR__));

$loader = include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../init_autoloader.php';

Zend\Mvc\Application::init(include __DIR__ . '/../config/application.config.php');