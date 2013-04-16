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

		$user_toto = new SamUser\Entity\User();
		$user_toto->setUsername('toto');
		$user_toto->setEmail('toto@toto.fr');
		$user_toto->setDisplayName('Toto');
		$user_toto->setsetPassword($bcrypt->create('toto123'));
		$user_toto->addRole($role_Admin);

		$user_toto = new SamUser\Entity\User();
		$user_toto->setUsername('titi');
		$user_toto->setEmail('titi@toto.fr');
		$user_toto->setDisplayName('Titi');
		$user_toto->setsetPassword($bcrypt->create('toto123'));
		$user_toto->addRole($role_Utilisateur);

		$user_toto = new SamUser\Entity\User();
		$user_toto->setUsername('toto1');
		$user_toto->setEmail('toto@toto.fr');
		$user_toto->setDisplayName('toto');
		$user_toto->setsetPassword($bcrypt->create('toto123'));
		$user_toto->addRole($role_Collection);

		$user_toto = new SamUser\Entity\User();
		$user_toto->setUsername('toto2');
		$user_toto->setEmail('toto@toto.fr');
		$user_toto->setDisplayName('toto');
		$user_toto->setsetPassword($bcrypt->create('toto123'));
		$user_toto->addRole($role_Parcours);

		$user_toto = new SamUser\Entity\User();
		$user_toto->setUsername('toto3');
		$user_toto->setEmail('toto@toto.fr');
		$user_toto->setDisplayName('toto');
		$user_toto->setsetPassword($bcrypt->create('toto123'));
		$user_toto->addRole($role_Utilisateur);



		$manager->flush();
		

	}
}
