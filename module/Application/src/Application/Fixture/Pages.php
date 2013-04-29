<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Pages implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		/* ************** *
		 * PAGE D'ACCUEIL *
		 * ************** */

		$page_accueil = new Application\Entity\Page(
			'Accueil',
			'
				<div class="hero-unit">
    				<h1>Moving-BO</h1>
    				<h4>Prototype de Back-Office pour le projet Cervin</h4>
				</div>
			'
		);
		$manager->persist($page_accueil);
		$manager->flush();
	}
}