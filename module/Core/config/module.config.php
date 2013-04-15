<?php

namespace Core;

return array(
	
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
			'Core_fixture' => __DIR__ . '/../src/Collection/Fixture',
	),

);
