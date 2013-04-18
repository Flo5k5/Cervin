<?php


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Zend\Crypt\Password\Bcrypt;
class Roles implements FixtureInterface
{
	/*
	 * Initialisation des types de bases d'artefacts
	 * et des champs qui les décrivent
	 */
	public function load(ObjectManager $manager)
	{
		
		/* *************************************** *
		 * Création des Roles et de 5 utilisateurs *
		 * *************************************** */
		
		/*
		 * Roles
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

		/*
		 * Utilisateurs
		 */

		$admin = new SamUser\Entity\User();
		$admin->setUsername('adminlogin');
		$admin->setEmail('admin@mail.fr');
		$admin->setDisplayName('Administrateur Test');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$admin->setPassword($bcrypt->create('toto123'));
		$admin->addRole($role_Admin);

		$utilisateur = new SamUser\Entity\User();
		$utilisateur->setUsername('utilisateurlogin');
		$utilisateur->setEmail('utilisateur@mail.fr');
		$utilisateur->setDisplayName('Utilisateur Test');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$utilisateur->setPassword($bcrypt->create('toto123'));
		$utilisateur->addRole($role_Utilisateur);

		$collection = new SamUser\Entity\User();
		$collection->setUsername('collectionlogin');
		$collection->setEmail('collection@mail.fr');
		$collection->setDisplayName('Collection Test');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$collection->setPassword($bcrypt->create('toto123'));
		$collection->addRole($role_Collection);

		$parcours = new SamUser\Entity\User();
		$parcours->setUsername('parcourslogin');
		$parcours->setEmail('parcours@mail.fr');
		$parcours->setDisplayName('Parcours Test');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$parcours->setPassword($bcrypt->create('toto123'));
		$parcours->addRole($role_Parcours);

		$manager->persist($admin);
		$manager->persist($utilisateur);
		$manager->persist($collection);
		$manager->persist($parcours);
		$manager->flush();
		
	}
	
}
