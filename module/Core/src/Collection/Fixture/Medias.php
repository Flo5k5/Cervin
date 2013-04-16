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
		$type_media_image = new Collection\Entity\TypeElement();
		$type_media_image->__set('nom', 'Image');
		$type_media_image->__set('type', 'media');
		
		$champ_fichier = new Collection\Entity\Champ();
		$champ_fichier->__set('label', 'Fichier');
		$champ_fichier->__set('description', 'Le fichier contenant l\'image');
		$champ_fichier->__set('format', 'fichier');
		$champ_fichier->__set('type_element', $type_media_image);
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'La date de publication de l\'image');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_media_image);
		
		$champ_format = new Collection\Entity\Champ();
		$champ_format->__set('label', 'Format');
		$champ_format->__set('description', 'Le format d\'encodage de l\'image');
		$champ_format->__set('format', 'texte');
		$champ_format->__set('type_element', $type_media_image);
		
		$manager->persist($type_media_image);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Video
		*/
		$type_media_video = new Collection\Entity\TypeElement();
		$type_media_video->__set('nom', 'Vid�o');
		$type_media_video->__set('type', 'media');
		
		$champ_fichier = new Collection\Entity\Champ();
		$champ_fichier->__set('label', 'Fichier');
		$champ_fichier->__set('description', 'Le fichier contenant la vid�o');
		$champ_fichier->__set('format', 'fichier');
		$champ_fichier->__set('type_element', $type_media_video);
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'La date de publication de la vid�o');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_media_video);
		
		$champ_format = new Collection\Entity\Champ();
		$champ_format->__set('label', 'Format');
		$champ_format->__set('description', 'Le format d\'encodage de la vid�o');
		$champ_format->__set('format', 'texte');
		$champ_format->__set('type_element', $type_media_video);
		
		$manager->persist($type_media_video);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Son
		*/
		$type_media_son = new Collection\Entity\TypeElement();
		$type_media_son->__set('nom', 'Son');
		$type_media_son->__set('type', 'media');
		
		$champ_fichier = new Collection\Entity\Champ();
		$champ_fichier->__set('label', 'Fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le son');
		$champ_fichier->__set('format', 'fichier');
		$champ_fichier->__set('type_element', $type_media_son);
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'La date de publication du son');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_media_son);
		
		$champ_format = new Collection\Entity\Champ();
		$champ_format->__set('label', 'Format');
		$champ_format->__set('description', 'Le format d\'encodage du son');
		$champ_format->__set('format', 'texte');
		$champ_format->__set('type_element', $type_media_son);
		
		$manager->persist($type_media_son);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Logiciel
		*/
		$type_media_logiciel = new Collection\Entity\TypeElement();
		$type_media_logiciel->__set('nom', 'Logiciel');
		$type_media_logiciel->__set('type', 'media');
		
		$champ_fichier = new Collection\Entity\Champ();
		$champ_fichier->__set('label', 'Fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le code source du logiciel');
		$champ_fichier->__set('format', 'fichier');
		$champ_fichier->__set('type_element', $type_media_logiciel);
		
		$champ_version = new Collection\Entity\Champ();
		$champ_version->__set('label', 'Version');
		$champ_version->__set('description', 'Le num�ro de version du logiciel');
		$champ_version->__set('format', 'texte');
		$champ_version->__set('type_element', $type_media_logiciel);
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'La date de publication du logiciel');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_media_logiciel);
		
		$champ_format = new Collection\Entity\Champ();
		$champ_format->__set('label', 'Format');
		$champ_format->__set('description', 'Le format d\'encodage du code source');
		$champ_format->__set('format', 'texte');
		$champ_format->__set('type_element', $type_media_logiciel);
		
		$manager->persist($type_media_logiciel);
		$manager->persist($champ_format);
		$manager->persist($champ_version);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->flush();
		
		/*
		 * M�dia : Modele 3D
		*/
		$type_media_modele3d = new Collection\Entity\TypeElement();
		$type_media_modele3d->__set('nom', 'Mod�le 3D');
		$type_media_modele3d->__set('type', 'media');
		
		$champ_fichier = new Collection\Entity\Champ();
		$champ_fichier->__set('label', 'Fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le mod�le 3D');
		$champ_fichier->__set('format', 'fichier');
		$champ_fichier->__set('type_element', $type_media_modele3d);
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'La date de publication du mod�le 3D');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_media_modele3d);
		
		$champ_format = new Collection\Entity\Champ();
		$champ_format->__set('label', 'Format');
		$champ_format->__set('description', 'Le format d\'encodage du mod�le 3D');
		$champ_format->__set('format', 'texte');
		$champ_format->__set('type_element', $type_media_modele3d);
		
		$manager->persist($type_media_modele3d);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Jeu de donn�es
		*/
		$type_media_jeudonnees = new Collection\Entity\TypeElement();
		$type_media_jeudonnees->__set('nom', 'Jeu de donn�es');
		$type_media_jeudonnees->__set('type', 'media');
		
		$champ_fichier = new Collection\Entity\Champ();
		$champ_fichier->__set('label', 'Fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le jeu de donn�es');
		$champ_fichier->__set('format', 'fichier');
		$champ_fichier->__set('type_element', $type_media_jeudonnees);
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'La date de publication du jeu de donn�es');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_media_jeudonnees);
		
		$champ_format = new Collection\Entity\Champ();
		$champ_format->__set('label', 'Format');
		$champ_format->__set('description', 'Le format d\'encodage du jeu de donn�es');
		$champ_format->__set('format', 'texte');
		$champ_format->__set('type_element', $type_media_jeudonnees);
		
		$manager->persist($type_media_jeudonnees);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
		/*
		 * M�dia : Autre
		*/
		$type_media_autre = new Collection\Entity\TypeElement();
		$type_media_autre->__set('nom', 'Autre');
		$type_media_autre->__set('type', 'media');
		
		$champ_type = new Collection\Entity\Champ();
		$champ_type->__set('label', 'Type de m�dia');
		$champ_type->__set('description', 'Le type de fichier qu\'est ce m�dia');
		$champ_type->__set('format', 'date');
		$champ_type->__set('type_element', $type_media_autre);
		
		$champ_fichier = new Collection\Entity\Champ();
		$champ_fichier->__set('label', 'Fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le m�dia');
		$champ_fichier->__set('format', 'fichier');
		$champ_fichier->__set('type_element', $type_media_autre);
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'La date de publication du m�dia');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_media_autre);
		
		$champ_format = new Collection\Entity\Champ();
		$champ_format->__set('label', 'Format');
		$champ_format->__set('description', 'Le format d\'encodage du m�dia');
		$champ_format->__set('format', 'texte');
		$champ_format->__set('type_element', $type_media_autre);
		
		$manager->persist($type_media_autre);
		$manager->persist($champ_type);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		$manager->flush();
		
	}
}
