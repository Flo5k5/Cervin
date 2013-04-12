<?php
return array(
		
	// Doctrine config
	'doctrine' => array(
		'driver' => array(
			'Core_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(
						__DIR__ . '/../src/Parcours/Entity', 
						__DIR__ . '/../src/Collection/Entity',
						__DIR__ . '/../src/Collection/Entity/TypesArtefacts',
						__DIR__ . '/../src/Collection/Entity/TypesMedias'
				)
			),
			'orm_default' => array(
				'drivers' => array(
					'Collection\Entity' => 'Core_driver',
					'Parcours\Entity' => 'Core_driver',
					'Collection\Entity\TypesArtefacts' => 'Core_driver',
					'Collection\Entity\TypesMedias' => 'Core_driver'
				)
			)
		)
	),
	
);
