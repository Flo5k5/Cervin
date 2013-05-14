<?php
namespace Application;
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Admin' => 'Admin\Controller\AdminController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                // 'priority' => 1000,
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        'controller' => 'Admin',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'gestion-users' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/gestion-users',
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'editusers',
                            ),
                        ),
                    ),
                    'changeUserAjax' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/changeUserAjax[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'changeUserAjax',
                            ),
                            
                        ),
                        
                    ),
                    'editAccueil' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/editAccueil',
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'editAccueil',
                            ),
                            
                        ),
                        
                    ),
                    'demandeRole' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/demandeRole[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'demandeRole',
                            ),
                            
                        ),
                        
                    ),
                    'refueRole' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/refueRole[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'refueRole',
                            ),
                            
                        ),
                        
                    ),
                    /*
                    'authenticate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'authenticate',
                            ),
                        ),
                    ),
                    //*/
                ),
            ),
            
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'                 => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index'       => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'                     => __DIR__ . '/../view/error/404.phtml',
            'error/index'                   => __DIR__ . '/../view/error/index.phtml',
            'admin/admin/editusers'         => __DIR__ . '/../view/Admin/Admin/editusers.phtml',
            'admin/admin/edit-accueil'      => __DIR__ . '/../view/Admin/Admin/edit-accueil.phtml'            
        ),
        'template_path_stack' => array(
            'Admin' => __DIR__ . '/../view',
            'Application' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/SamUser/Entity',
            ),
            'users_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/SamUser/Entity')
            ),
            'Application_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(
                        __DIR__ . '/../src/Application/Entity',
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'SamUser\Entity' => 'zfcuser_entity',
                    'Application\Entity' => 'Application_driver',
                ),
            ),
        ),
    ),
    'zfcuser' => array(
        // telling ZfcUser to use our own class
        'user_entity_class'       => 'SamUser\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
    ),
    'bjyauthorize' => array(
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

        'role_providers'        => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entity_manager.orm_default',
                'role_entity_class' => 'SamUser\Entity\Role',
            ),
        ),
    ),
    'data-fixture' => array(
        'Roles_fixture' => __DIR__ . '/../src/SamUser/Fixture',
        'Pages_fixture' => __DIR__ . '/../src/Application/Fixture',
    ),

);