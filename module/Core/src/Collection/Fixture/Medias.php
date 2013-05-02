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
		
		/*
		 * M�dia : Video
		*/
		$type_media_video = new Collection\Entity\TypeElement('Vidéo', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_video, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant la vidéo');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_video, 'date');
		$champ_date->__set('description', 'La date de publication de la vidéo');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_video, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage de la vidéo');
		
		$manager->persist($type_media_video);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		
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
		
		/*
		 * M�dia : Logiciel
		*/
		$type_media_logiciel = new Collection\Entity\TypeElement('Logiciel', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_logiciel, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le code source du logiciel');
		
		$champ_version = new Collection\Entity\Champ('Version', $type_media_logiciel, 'texte');
		$champ_version->__set('description', 'Le numéro de version du logiciel');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_logiciel, 'date');
		$champ_date->__set('description', 'La date de publication du logiciel');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_logiciel, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du code source');
		
		$manager->persist($type_media_logiciel);
		$manager->persist($champ_format);
		$manager->persist($champ_version);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		
		/*
		 * M�dia : Modele 3D
		*/
		$type_media_modele3d = new Collection\Entity\TypeElement('Modèle 3D', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_modele3d, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le modèle 3D');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_modele3d, 'date');
		$champ_date->__set('description', 'La date de publication du modèle 3D');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_modele3d, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du modèle 3D');
		
		$manager->persist($type_media_modele3d);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		
		/*
		 * M�dia : Jeu de donn�es
		*/
		$type_media_jeudonnees = new Collection\Entity\TypeElement('Jeu de données', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_jeudonnees, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le jeu de données');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_jeudonnees, 'date');
		$champ_date->__set('description', 'La date de publication du jeu de données');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_jeudonnees, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du jeu de données');
		
		$manager->persist($type_media_jeudonnees);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		
		/*
		 * M�dia : Autre
		*/
		$type_media_autre = new Collection\Entity\TypeElement('Autre', 'media');
		
		$champ_type = new Collection\Entity\Champ('Type de média', $type_media_autre, 'date');
		$champ_type->__set('description', 'Le type de fichier qu\'est ce média');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_autre, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le média');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_autre, 'date');
		$champ_date->__set('description', 'La date de publication du média');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_autre, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du média');
		
		$manager->persist($type_media_autre);
		$manager->persist($champ_type);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		$manager->persist($champ_format);
		
		$manager->flush();




		/* ***************************** *
		 * QUELQUES INSANCES DE MEDIAS   *
		* ****************************** */
		
		/*
		 * Une image
		 */
		$logo_cervin = new Collection\Entity\Media('Logo Cervin', $type_media_image);
		$logo_cervin->description = '<h2><u>Le logo du projet CERVIN</u></h2>';
		$logo_cervin->datas = new \Doctrine\Common\Collections\ArrayCollection();

		$champ_fichier = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fichier', 'type_element'=>$type_media_image));
		if ($champ_fichier == null) {
			throw new Exception('unexpected');
		}
		$data_fichier = new Collection\Entity\Data($logo_cervin, $champ_fichier);
		$data_fichier->fichier = 'inconnu.jpg';
		$logo_cervin->datas->add($data_fichier);
		
		$champ_date = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date', 'type_element'=>$type_media_image));
		if ($champ_date == null) {
			throw new Exception('unexpected');
		}
		$data_date = new Collection\Entity\Data($logo_cervin, $champ_date);
		$data_date->date = new DateTime('1999-10-09');
		$logo_cervin->datas->add($data_date);
		
		$champ_format = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Format', 'type_element'=>$type_media_image));
		if ($champ_format == null) {
			throw new Exception('unexpected');
		}
		$data_format = new Collection\Entity\Data($logo_cervin, $champ_format);
		$data_format->texte = 'Image jpeg';
		$logo_cervin->datas->add($data_format);
		
		$manager->persist($logo_cervin);
		$manager->flush();

		/*
		 * Un logiciel
		 */
		$logiciel = new Collection\Entity\Media('Logiciel sans nom', $type_media_logiciel);
		$logiciel->description = '<ul><li>Exemple de logiciel de la collection...</li><li>Ceci est un exemple</li></ul>';
		$logiciel->datas = new \Doctrine\Common\Collections\ArrayCollection();

		$champ_fichier = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fichier', 'type_element'=>$type_media_logiciel));
		if ($champ_fichier == null) {
			throw new Exception('unexpected');
		}
		$data_fichier = new Collection\Entity\Data($logiciel, $champ_fichier);
		$data_fichier->fichier = 'inconnu.exe';
		$logiciel->datas->add($data_fichier);

		$champ_version = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Version', 'type_element'=>$type_media_logiciel));
		if ($champ_version == null) {
			throw new Exception('unexpected');
		}
		$data_version = new Collection\Entity\Data($logiciel, $champ_version);
		$data_version->texte = '2.0';
		$logiciel->datas->add($data_version);
		
		$champ_date = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date', 'type_element'=>$type_media_logiciel));
		if ($champ_date == null) {
			throw new Exception('unexpected');
		}
		$data_date = new Collection\Entity\Data($logiciel, $champ_date);
		$data_date->date = new DateTime('1999-10-09');
		$logiciel->datas->add($data_date);
		
		$champ_format = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Format', 'type_element'=>$type_media_logiciel));
		if ($champ_format == null) {
			throw new Exception('unexpected');
		}
		$data_format = new Collection\Entity\Data($logiciel, $champ_format);
		$data_format->texte = 'Fichier exe';
		$logiciel->datas->add($data_format);
		
		$manager->persist($logiciel);
		$manager->flush();

		/*
		 * M�dia : Logiciel
		* /
		$type_media_logiciel = new Collection\Entity\TypeElement('Logiciel', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_logiciel, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le code source du logiciel');
		
		$champ_version = new Collection\Entity\Champ('Version', $type_media_logiciel, 'texte');
		$champ_version->__set('description', 'Le numéro de version du logiciel');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_logiciel, 'date');
		$champ_date->__set('description', 'La date de publication du logiciel');
		
		$champ_format = new Collection\Entity\Champ('Format', $type_media_logiciel, 'texte');
		$champ_format->__set('description', 'Le format d\'encodage du code source');
		
		$manager->persist($type_media_logiciel);
		$manager->persist($champ_format);
		$manager->persist($champ_version);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		//*/
	}
}
