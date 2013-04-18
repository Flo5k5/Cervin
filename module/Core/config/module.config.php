<?php

namespace Core;

return array(
	'controllers' => array(
        'invokables' => array(
            'typeElement' => 'Collection\Controller\TypeElementController',
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
	//'data-fixture' => array(
	//		'Collection_fixture' => __DIR__ . '/../src/Collection/Fixture'
	//),

);
