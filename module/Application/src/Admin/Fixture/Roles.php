<?php


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Roles implements FixtureInterface
{
	/*
	 * Initialisation des types de bases d'artefacts
	 * et des champs qui les décrivent
	 */
	public function load(ObjectManager $manager)
	{
		
		/* *********************************** *
		 * TYPES D'ARTEFACTS + CHAMPS ASSOCIES *
		 * *********************************** */
		
		/*
		 * Artefact : Matériel
		 */
		$role_Visiteur = new SamUser\Entity\Role();
		$role_Visiteur->setRoleId('Visiteur');

		$role_Utilisateur = new SamUser\Entity\Role();
		$role_Utilisateur->setRoleId('Utilisateur');
		$role_Utilisateur->setParent($role_Visiteur);

		$role_Collection = new SamUser\Entity\Role();
		$role_Collection->setRoleId('Collection');
		$role_Collection->setParent($role_Utilisateur);

		$role_Parcours = new SamUser\Entity\Role();
		$role_Parcours->setRoleId('Parcours');
		$role_Parcours->setParent($role_Collection);
		

		$role_Admin = new SamUser\Entity\Role();
		$role_Admin->setRoleId('Admin');
		$role_Admin->setParent($role_Parcours);

		$manager->persist($role_Visiteur);
		$manager->persist($role_Utilisateur);
		$manager->persist($role_Collection);
		$manager->persist($role_Parcours);
		$manager->persist($role_Admin);
		$manager->flush();
		

	}
}
