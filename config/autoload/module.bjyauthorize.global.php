<?php
return array(

    'controllers' => array(
        'invokables' => array(
            'zfcuser' => 'ZfcUser\Controller\UserController',
            'Admin' => 'Admin\Controller\AdminController',
        ),
    ),
    'bjyauthorize' => array(

        // set the 'guest' role as default (must be defined in a role provider)
        'default_role' => 'Visiteur',

        'authenticated_role'    => 'Utilisateur',
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'role_providers'        => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entity_manager.orm_default',
                'role_entity_class' => 'SamUser\Entity\Role',
            ),
        ),
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'menuAdmin' => array(),
                'menuCollection' => array(),
                'menuParcours' => array(),
                'menuUtilisateur' => array(),
                //'pants' => array(),
            ),
        ),
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    // allow guests and users (and admins, through inheritance)
                    // the "wear" privilege on the resource "pants"
                    //array(array('guest', 'user'), 'pants', 'wear'),
                    array(array('Admin'), 'menuAdmin'),
                    array(array('Collection'), 'menuCollection'),
                    array(array('Parcours'), 'menuParcours'),
                    array(array('Utilisateur'), 'menuUtilisateur'),
                ),

                // Don't mix allow/deny rules if you are using role inheritance.
                // There are some weird bugs.
                'deny' => array(
                    // ...
                ),
            ),
        ),
        'guards' => array(
            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all controllers and actions unless they are specified here.
             * You may omit the 'action' index to allow access to the entire controller
             */
            'BjyAuthorize\Guard\Controller' => array(
                array(
                    'controller' => 'Album\Controller\Album',
                    'roles' => array('Visiteur')
                ),

                array(
                    'controller' => 'Application\Controller\Index',
                    'action' => 'index',
                    'roles' => array()
                ),

                array(
                    'controller' => 'zfcuser',
                    'roles' => array()
                ),
                array(
                    'controller' => 'zfcuser',
                    'action' => 'register', 
                    'roles' => array('Visiteur')
                ),

                array(
                    'controller' => 'Admin',
                    'roles' => array('Admin')
                ),
                array(
                    'controller' => 'Admin',
                    'action' => 'editusers',
                    'roles' => array('Admin')
                ),
                array(
                    'controller' => 'Admin',
                    'action' => 'changeUserAjax',
                    'roles' => array('Admin')
                ),

                array(
                    'controller' => 'typeElement',
                    'roles' => array('Admin')
                ),
                array(
                    'controller' => 'typeElement',
                    'action' => 'editTypeElementAjax',
                    'roles' => array('Admin')
                ),
                array(
                    'controller' => 'typeElement',
                    'action' => 'add',
                    'roles' => array('Admin')
                ),

            	array(
            		'controller' => 'Collection',
            		'action' => 'consulter',
            		'roles' => array('Utilisateur')
            	),
        		array(
        				'controller' => 'Collection',
        				'action' => 'test',
        				'roles' => array('Utilisateur')
        		),
            		
                array(
                    'controller' => 'Artefact',
                    'roles' => array('Collection')
                ),
                array(
                    'controller' => 'Artefact',
                    'action' => 'ajouter',
                    'roles' => array('Collection')
                ),
                array(
                    'controller' => 'Artefact',
                    'action' => 'getFormAjax',
                    'roles' => array('Collection')
                ),

                array(
                    'controller' => 'Media',
                    'roles' => array('Collection')
                ),
                array(
                    'controller' => 'Media',
                    'action' => 'ajouter',
                    'roles' => array('Collection')
                ),
                array(
                    'controller' => 'Media',
                    'action' => 'getFormAjax',
                    'roles' => array('Collection')
                ),
                array(
                    'controller' => 'fileupload_examples',
                    'roles' => array('Visiteur')
                ),
                array(
                    'controller' => 'fileupload_prgexamples',
                    'roles' => array('Visiteur')
                ),
                array(
                    'controller' => 'fileupload_progressexamples',
                    'roles' => array('Visiteur')
                ),

                array(
                    'controller' => 'Semantique',
                    'roles' => array('Admin')
                ),
            ),

            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all routes unless they are specified here.
             */
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'album', 'roles' => array('Visiteur')),

                array('route' => 'home', 'roles' => array('Visiteur')),

                array('route' => 'admin', 'roles' => array('Admin')),
                array('route' => 'admin/gestion-users', 'roles' => array('Admin')),
                array('route' => 'admin/changeUserAjax', 'roles' => array('Admin')),

                array('route' => 'zfcuser', 'roles' => array('Utilisateur')),
                array('route' => 'zfcuser/logout', 'roles' => array('Utilisateur')),
                array('route' => 'zfcuser/login', 'roles' => array('Visiteur')),
                array('route' => 'zfcuser/register', 'roles' => array('Visiteur')),
                array('route' => 'zfcuser/changepassword', 'roles' => array('Utilisateur')),
                array('route' => 'zfcuser/changeemail', 'roles' => array('Utilisateur')),
                
                array('route' => 'typeElement', 'roles' => array('Admin')),
                array('route' => 'typeElement/add', 'roles' => array('Admin')),
                array('route' => 'typeElement/editTypeElementAjax', 'roles' => array('Admin')),
            		
				array('route' => 'collection/consulter', 'roles' => array('Utilisateur')),
				array('route' => 'collection/test', 'roles' => array('Utilisateur')),

                array('route' => 'artefact', 'roles' => array('Collection')),
                array('route' => 'artefact/ajouter', 'roles' => array('Collection')),
                array('route' => 'artefact/getFormAjax', 'roles' => array('Collection')),
                array('route' => 'artefact/voirArtefact', 'roles' => array('Collection')),
                array('route' => 'artefact/editArtefact', 'roles' => array('Collection')),

                array('route' => 'media', 'roles' => array('Collection')),
                array('route' => 'media/ajouter', 'roles' => array('Collection')),
                array('route' => 'media/getFormAjax', 'roles' => array('Collection')),

                array('route' => 'semantique', 'roles' => array('Admin')),
                array('route' => 'semantique/ajouter', 'roles' => array('Admin')),
                array('route' => 'semantique/supprimer', 'roles' => array('Admin')),
                array('route' => 'semantique/modifier', 'roles' => array('Admin')),

                array('route' => 'fileupload', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/single', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/success', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/multi-html5', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/collection', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/partial', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/prg', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/prg/multi-html5', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/prg/fieldset', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/progress', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/progress/session', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/progress/session_partial', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/progress/session-progress', 'roles' => array('Visiteur')),
            ),
        ), 
    ),
);