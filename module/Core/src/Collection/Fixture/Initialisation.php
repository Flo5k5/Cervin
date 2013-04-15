<?php

namespace Collection;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Fixture implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		
		$type_element = new Entity\TypeElement();
		$type_element->__set('nom', 'Test Type Element');
		$type_element->__set('type', 'artefact');
		$manager->persist($type_element);
		$manager->flush();
		
	}
}
