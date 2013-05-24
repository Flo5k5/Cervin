<?php
return array(

    'controllers' => array(
        'invokables' => array(
            'zfcuser' => 'ZfcUser\Controller\UserController',
            'Admin' => 'Admin\Controller\AdminController',
        ),
    ),
    'bjyauthorize' => array(

        // set the 'Visiteur' role as default (must be defined in a role provider)
        'default_role' => 'Visiteur',

        'authenticated_role'    => 'Utilisateur',
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'role_providers'        => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'SamUser\Entity\Role',
            ),
        ),
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'Admin' => array(),
                'Parcours' => array(),
                'Collection' => array(),
                'Utilisateur' => array(),
                //'pants' => array(),
            ),
        ),
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    // allow guests and users (and admins, through inheritance)
                    // the "wear" privilege on the resource "pants"
                    //array(array('guest', 'user'), 'pants', 'wear'),
                    array(array('Admin'), 'Admin'),
                    array(array('Parcours'), 'Parcours'),
                    array(array('Collection'), 'Collection'),
                    array(array('Utilisateur'), 'Utilisateur'),
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
                    'action' => 'demandeRole', 
                    'roles' => array('Utilisateur')
                ),

                array(
                    'controller' => 'Admin',
                    'action' => 'refueRole', 
                    'roles' => array('Admin')
                ),
                array(
                    'controller' => 'typeElement',
                    'roles' => array('Admin')
                ),

            	array(
            		'controller' => 'Collection',
            		'roles' => array('Utilisateur')
            	),
            		
                array(
                    'controller' => 'Artefact',
                    'roles' => array('Utilisateur')
                ),
                array(
                    'controller' => 'Artefact',
                    'action' => 'voirArtefact', 
                    'roles' => array('Utilisateur')
                ),

                array(
                    'controller' => 'Media',
                    'roles' => array('Utilisateur')
                ),
                
                array(
                    'controller' => 'Parcours',
                    'roles' => array('Utilisateur')
                ),

                array(
                    'controller' => 'Scene',
                    'roles' => array('Utilisateur')
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
            		
            	array(
            		'controller' => 'SemantiqueTransition',
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
                array('route' => 'admin/editAccueil', 'roles' => array('Admin')),
                array('route' => 'admin/demandeRole', 'roles' => array('Utilisateur')),
                array('route' => 'admin/refueRole', 'roles' => array('Admin')),

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

                array('route' => 'artefact', 'roles' => array('Collection')),
                array('route' => 'artefact/ajouter', 'roles' => array('Collection')),
                array('route' => 'artefact/voirArtefact', 'roles' => array('Utilisateur')),
                array('route' => 'artefact/editArtefact', 'roles' => array('Collection')),
                array('route' => 'artefact/removeArtefact', 'roles' => array('Collection')),
            	array('route' => 'artefact/addRelationArtefactSemantique', 'roles' => array('Utilisateur')),
            	array('route' => 'artefact/getAllArtefact', 'roles' => array('Utilisateur')),
            	array('route' => 'artefact/addRelationArtefactMedia', 'roles' => array('Utilisateur')),
            	array('route' => 'artefact/getAllMedia', 'roles' => array('Utilisateur')),

                array('route' => 'media', 'roles' => array('Collection')),
                array('route' => 'media/ajouter', 'roles' => array('Collection')),
                array('route' => 'media/voirMedia', 'roles' => array('Utilisateur')),
                array('route' => 'media/editMedia', 'roles' => array('Collection')),
                array('route' => 'media/removeMedia', 'roles' => array('Collection')),
            	array('route' => 'media/addRelationMediaArtefact', 'roles' => array('Utilisateur')),
            	array('route' => 'media/getAllArtefact', 'roles' => array('Utilisateur')),

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

                array('route' => 'parcours', 'roles' => array('Utilisateur')),
                array('route' => 'parcours/voir', 'roles' => array('Utilisateur')),
                array('route' => 'parcours/ajouter', 'roles' => array('Parcours')),
                array('route' => 'parcours/modifierTransition', 'roles' => array('Parcours')),
                array('route' => 'parcours/modifier', 'roles' => array('Parcours')),

            	array('route' => 'semantiquetransition', 'roles' => array('Admin')),
            	array('route' => 'semantiquetransition/ajouter', 'roles' => array('Admin')),
            	array('route' => 'semantiquetransition/modifier', 'roles' => array('Admin')),
            	array('route' => 'semantiquetransition/supprimer', 'roles' => array('Admin')),

                array('route' => 'scene', 'roles' => array('Utilisateur')),
                array('route' => 'scene/voirScene', 'roles' => array('Utilisateur')),
                array('route' => 'scene/removeScene', 'roles' => array('Parcours')),
                array('route' => 'scene/ajouterScene', 'roles' => array('Parcours')),
                array('route' => 'scene/editScene', 'roles' => array('Parcours')),
                array('route' => 'scene/deleteElement', 'roles' => array('Parcours')),
            ),
        ), 
    ),
);
