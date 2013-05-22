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
            'Relation' => 'Collection\Controller\RelationController',
            'Parcours' => 'Parcours\Controller\ParcoursController',
            'SemantiqueTransition' => 'Parcours\Controller\SemantiqueTransitionController',
            'Scene' => 'Parcours\Controller\SceneController',
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
                    'voirRelationArtefact' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/voirRelationArtefact',
                            'defaults' => array(
                                'controller' => 'Artefact',
                                'action'     => 'voirRelationArtefact',
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
                	'removeArtefact' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/removeArtefact/:id',
                			'constraints' => array(
                				'id'     => '[0-9]+',
                			),
                			'defaults' => array(
                				'controller' => 'Artefact',
                				'action'     => 'removeArtefact',
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
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/ajouter[/:type_element_id]',
                            'constraints' => array(
                                'type_element_id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Media',
                                'action'     => 'ajouter',
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
                    'voirRelationMedia' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/voirRelationArtefact',
                            'defaults' => array(
                                'controller' => 'Artefact',
                                'action'     => 'voirRelationArtefact',
                            ),
                        ),
                    ),
                    'editMedia' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/editMedia/:id[/:idData]',
                            'constraints' => array(
                                'idData'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Media',
                                'action'     => 'editMedia',
                            ),
                        ),
                    ),
                    'removeMedia' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/removeMedia/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Media',
                                'action'     => 'removeMedia',
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

            'parcours' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/parcours',
                    'defaults' => array(
                        'controller' => 'Parcours',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    
                ),
            ),

        	'semantiquetransition' => array(
        		'type' => 'Zend\Mvc\Router\Http\Literal',
        		'options' => array(
        			'route' => '/semantiquetransition',
        				'defaults' => array(
        					'controller' => 'SemantiqueTransition',
        					'action'     => 'index',
        				),
        			),
        			'may_terminate' => true,
        			'child_routes' => array(
        				/*'ajouter' => array(
        					'type' => 'Zend\Mvc\Router\Http\Literal',
        					'options' => array(
        						'route' => '/ajouter',
        						'defaults' => array(
        							'controller' => 'SemantiqueTransition',
        							'action'     => 'ajouter',
        						),
        					),
        				),*/
        				/*'supprimer' => array(
        					'type' => 'segment',
        					'options' => array(
        						'route' => '/supprimer/:id',
        						'constraints' => array(
        							'id'     => '[0-9]+',
        						),
        						'defaults' => array(
        							'controller' => 'SemantiqueTransition',
        							'action'     => 'supprimer',
        						),
        					),
        				),*/
        				'modifier' => array(
        					'type' => 'segment',
        					'options' => array(
        						'route' => '/modifier/:id',
        						'constraints' => array(
        							'id'     => '[0-9]+',
        						),
        						'defaults' => array(
        							'controller' => 'SemantiqueTransition',
        							'action'     => 'modifier',
        						),
        					),
        				),
        			),
        		),

            'scene' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/scene',
                    'defaults' => array(
                        'controller' => 'Scene',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'voirScene' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/voirScene/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Scene',
                                'action'     => 'voirScene',
                            ),
                        ),
                    ),
                    'removeScene' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/removeScene/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Scene',
                                'action'     => 'removeScene',
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),
		
    'view_manager' => array(
    	'template_map' => array(
    		
    		'collection/collection/consulter'    => __DIR__ . '/../view/Collection/Collection/consulter.phtml',
    			
    		'collection/artefact/ajouter'        => __DIR__ . '/../view/Collection/Artefact/ajouter.phtml',
    		'collection/artefact/edit-artefact'  => __DIR__ . '/../view/Collection/Artefact/edit-artefact.phtml',
    		'collection/artefact/voir-artefact'  => __DIR__ . '/../view/Collection/Artefact/voir-artefact.phtml',

    		'collection/media/ajouter'           => __DIR__ . '/../view/Collection/Media/ajouter.phtml',
    		'collection/media/edit-media'        => __DIR__ . '/../view/Collection/Media/edit-media.phtml',
    		'collection/media/voir-media'        => __DIR__ . '/../view/Collection/Media/voir-media.phtml',
    			
    		'collection/semantique/index'        => __DIR__ . '/../view/Collection/Semantique/index.phtml',
    		'collection/semantique/ajouter'      => __DIR__ . '/../view/Collection/Semantique/ajouter.phtml',
    		'collection/semantique/modifier'     => __DIR__ . '/../view/Collection/Semantique/modifier.phtml',
    			
    		'collection/type-element/index'      => __DIR__ . '/../view/Collection/Type-Element/index.phtml',
    		'collection/type-element/add'        => __DIR__ . '/../view/Collection/Type-Element/add.phtml'
    	),
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
			'Collection_fixture' => __DIR__ . '/../src/Collection/Fixture',
			'Parcours_fixture' => __DIR__ . '/../src/Parcours/Fixture'
	),

);
