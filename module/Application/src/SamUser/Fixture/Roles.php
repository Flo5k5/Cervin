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
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$user_toto->setPassword($bcrypt->create('toto123'));
		$user_toto->addRole($role_Admin);

		$user_titi = new SamUser\Entity\User();
		$user_titi->setUsername('titi');
		$user_titi->setEmail('titi@toto.fr');
		$user_titi->setDisplayName('Titi');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$user_titi->setPassword($bcrypt->create('toto123'));
		$user_titi->addRole($role_Utilisateur);

		$user_toto1 = new SamUser\Entity\User();
		$user_toto1->setUsername('toto1');
		$user_toto1->setEmail('toto1@toto.fr');
		$user_toto1->setDisplayName('toto');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$user_toto1->setPassword($bcrypt->create('toto123'));
		$user_toto1->addRole($role_Collection);

		$user_toto2 = new SamUser\Entity\User();
		$user_toto2->setUsername('toto2');
		$user_toto2->setEmail('toto2@toto.fr');
		$user_toto2->setDisplayName('toto');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$user_toto2->setPassword($bcrypt->create('toto123'));
		$user_toto2->addRole($role_Parcours);

		$user_toto3 = new SamUser\Entity\User();
		$user_toto3->setUsername('toto3');
		$user_toto3->setEmail('toto3@toto.fr');
		$user_toto3->setDisplayName('toto');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$user_toto3->setPassword($bcrypt->create('toto123'));
		$user_toto3->addRole($role_Utilisateur);



		$manager->persist($user_toto1);
		$manager->persist($user_toto2);
		$manager->persist($user_toto3);
		$manager->persist($user_titi);
		$manager->persist($user_toto);


		$manager->flush();
		

	}
}
