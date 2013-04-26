<?php

namespace Core;

return array(
	'controllers' => array(
        'invokables' => array(
            'typeElement' => 'Collection\Controller\TypeElementController',
        	'Collection' => 'Collection\Controller\CollectionController',
            'Artefact' => 'Collection\Controller\ArtefactController',
            'Media' => 'Collection\Controller\MediaController',
            'Semantique' => 'Collection\Controller\SemantiqueController',
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
                            'route' => '/add[/:media-artefact]',
                            'constraints' => array(
                                'media-artefact'     => 'media|artefact',
                            ),
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
    		
            'artefact' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/artefact',
                    'defaults' => array(
                        'controller' => 'Artefact',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'ajouter' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/ajouter[/:type_element_id]',
                        	'constraints' => array(
                        		'type_element_id' => '[0-9]+'
                        	),
                            'defaults' => array(
                                'controller' => 'Artefact',
                                'action'     => 'ajouter',
                            ),
                        ),
                    ),
                    'getFormAjax' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/getFormAjax',
                            'defaults' => array(
                                'controller' => 'Artefact',
                                'action'     => 'getFormAjax',
                            ),
                        ),
                    ),
                    'voirArtefact' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/voirArtefact/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Artefact',
                                'action'     => 'voirArtefact',
                            ),
                        ),
                    ),
                    'editArtefact' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/editArtefact/:id[/:idData]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                                'idData' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Artefact',
                                'action'     => 'editArtefact',
                            ),
                        ),
                    ),
                ),
            ),

            'media' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/media',
                    'defaults' => array(
                        'controller' => 'Media',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'ajouter' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/ajouter',
                            'defaults' => array(
                                'controller' => 'Media',
                                'action'     => 'ajouter',
                            ),
                        ),
                    ),
                    'getFormAjax' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/getFormAjax',
                            'defaults' => array(
                                'controller' => 'Media',
                                'action'     => 'getFormAjax',
                            ),
                        ),
                    ),
                    'voirMedia' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/voirMedia/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Media',
                                'action'     => 'voirMedia',
                            ),
                        ),
                    ),
                    'editMedia' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/editMedia/:id[/:idData]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                                'idData' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Media',
                                'action'     => 'editMedia',
                            ),
                        ),
                    ),
                ),
            ),
            'semantique' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/semantique',
                    'defaults' => array(
                        'controller' => 'Semantique',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'ajouter' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/ajouter',
                            'defaults' => array(
                                'controller' => 'Semantique',
                                'action'     => 'ajouter',
                            ),
                        ),
                    ),
                    'supprimer' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/supprimer/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Semantique',
                                'action'     => 'supprimer',
                            ),
                        ),
                    ),
                    'modifier' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/modifier/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Semantique',
                                'action'     => 'modifier',
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
