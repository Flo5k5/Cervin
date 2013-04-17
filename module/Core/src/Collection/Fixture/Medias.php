<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Medias implements FixtureInterface
{
	/*
	 * Initialisation des types de bases d'artefacts
	 * et des champs qui les d�crivent
	 */
	public function load(ObjectManager $manager)
	{
		
		/* ********************************* *
		 * TYPES DE MEDIAS + CHAMPS ASSOCIES *
		* ********************************* */
		
		/*
		 * M�dia : Image
		 */
		$type_media_image = new Collection\Entity\TypeElement('Image', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_image, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant l\'image');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_image, 'date');
		$champ_date->__set('description', 'La date de publication de l\'image');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_image, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage de l\'image');
		
		$manager->persist($type_media_image);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Video
		*/
		$type_media_video = new Collection\Entity\TypeElement('Vid�o', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_video, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant la vid�o');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_video, 'date');
		$champ_date->__set('description', 'La date de publication de la vid�o');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_video, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage de la vid�o');
		
		$manager->persist($type_media_video);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Son
		*/
		$type_media_son = new Collection\Entity\TypeElement('Son', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_son, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le son');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_son, 'date');
		$champ_date->__set('description', 'La date de publication du son');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_son, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du son');
		
		$manager->persist($type_media_son);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Logiciel
		*/
		$type_media_logiciel = new Collection\Entity\TypeElement('Logiciel', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_logiciel, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le code source du logiciel');
		
		$champ_version = new Collection\Entity\Champ('Version', $type_media_logiciel, 'texte');
		$champ_version->__set('description', 'Le num�ro de version du logiciel');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_logiciel, 'date');
		$champ_date->__set('description', 'La date de publication du logiciel');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_logiciel, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du code source');
		
		$manager->persist($type_media_logiciel);
		$manager->persist($champ_format);
		$manager->persist($champ_version);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->flush();
		
		/*
		 * M�dia : Modele 3D
		*/
		$type_media_modele3d = new Collection\Entity\TypeElement('Mod�le 3D', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_modele3d, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le mod�le 3D');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_modele3d, 'date');
		$champ_date->__set('description', 'La date de publication du mod�le 3D');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_modele3d, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du mod�le 3D');
		
		$manager->persist($type_media_modele3d);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Jeu de donn�es
		*/
		$type_media_jeudonnees = new Collection\Entity\TypeElement('Jeu de donn�es', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_jeudonnees, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le jeu de donn�es');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_jeudonnees, 'date');
		$champ_date->__set('description', 'La date de publication du jeu de donn�es');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_jeudonnees, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du jeu de donn�es');
		
		$manager->persist($type_media_jeudonnees);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Autre
		*/
		$type_media_autre = new Collection\Entity\TypeElement('Autre', 'media');
		
		$champ_type = new Collection\Entity\Champ('Type de m�dia', $type_media_autre, 'date');
		$champ_type->__set('description', 'Le type de fichier qu\'est ce m�dia');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_autre, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le m�dia');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_autre, 'date');
		$champ_date->__set('description', 'La date de publication du m�dia');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_autre, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du m�dia');
		
		$manager->persist($type_media_autre);
		$manager->persist($champ_type);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
	}
}
