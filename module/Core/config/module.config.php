<?php

namespace Core;

return array(
	'controllers' => array(
        'invokables' => array(
            'typeElement' => 'Collection\Controller\TypeElementController',
        	'Collection' => 'Collection\Controller\CollectionController'
        ),
    ),
	'router' => array(
        'routes' => array(
        		
            'typeElement' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/typeElement',
                    'defaults' => array(
                        'controller' => 'typeElement',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'controller' => 'typeElement',
                                'action'     => 'add',
                            ),
                        ),
                    ),
                    'editTypeElementAjax' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/editTypeElementAjax[/:id][/:idChamp]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                                'idChamp'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'typeElement',
                                'action'     => 'editTypeElementAjax',
                            ),
                        ),
                    ),
                ),
            ),
        		
        	'collection' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
        		'options' => array(
        			'route' => '/collection',
        			'defaults' => array(
        				'controller' => 'Collection',
        				'action'     => 'index',
        			),
        		),
        		'may_terminate' => true,
        		'child_routes' => array(
        			'consulter' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        					'route' => '/consulter',
        					'defaults' => array(
        						'controller' => 'Collection',
        						'action'     => 'consulter',
        					),
        				),
        			),
        		),
        	),
        		
        ),
    ),
		
    'view_manager' => array(
	    'template_path_stack' => array(
	        'Collection' => __DIR__ . '/../view',
	    )
	),
    // Doctrine config
	'doctrine' => array(
		'driver' => array(
			'Core_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(
						__DIR__ . '/../src/Collection/Entity',
						__DIR__ . '/../src/Parcours/Entity'
				)
			),
			'orm_default' => array(
				'drivers' => array(
					'Collection\Entity' => 'Core_driver',
					'Parcours\Entity' => 'Core_driver',
				)
			)
		)
	),
	'data-fixture' => array(
			'Collection_fixture' => __DIR__ . '/../src/Collection/Fixture'
	),

);
