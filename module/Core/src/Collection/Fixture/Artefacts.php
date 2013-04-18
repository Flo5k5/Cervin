<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Artefacts implements FixtureInterface
{
	
	public function load(ObjectManager $manager)
	{
		
		/* *********************************** *
		 * TYPES D'ARTEFACTS + CHAMPS ASSOCIES *
		 * *********************************** */
		
		/*
		 * Artefact : Matériel
		 */
		$type_artefact_materiel = new Collection\Entity\TypeElement('Matériel', 'artefact');
		
		$champ_fabriquant = new Collection\Entity\Champ('Fabriquant', $type_artefact_materiel, 'texte');
		$champ_fabriquant->__set('description', 'La société qui fabrique ce mat�riel');
		
		$champ_debut = new Collection\Entity\Champ('Début de période', $type_artefact_materiel, 'date');
		$champ_debut->__set('description', 'Date du début de la période standard d\'utilisation du matériel');
		
		$champ_fin = new Collection\Entity\Champ('Fin de période', $type_artefact_materiel, 'date');
		$champ_fin->__set('description', 'Date du début de la période standard d\'utilisation du matériel');
		
		$manager->persist($type_artefact_materiel);
		$manager->persist($champ_fabriquant);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		$manager->flush();
		
		/*
		 * Artefact : Logiciel
		 */
		$type_artefact_logiciel = new Collection\Entity\TypeElement('Logiciel', 'artefact');
		
		$champ_editeur = new Collection\Entity\Champ('Editeur', $type_artefact_logiciel, 'texte');
		$champ_editeur->__set('description', 'L\'éditeur du logiciel');

		$champ_auteur = new Collection\Entity\Champ('Auteur(s)', $type_artefact_logiciel, 'texte');
		$champ_auteur->__set('description', 'Le (les) auteur(s) du logiciel, personne(s) ou société(s)');
		
		$champ_langage = new Collection\Entity\Champ('Langages de programmation', $type_artefact_logiciel, 'texte');
		$champ_langage->__set('description', 'Les principaux languages de programmation utilisés dans le code du logiciel');
		
		$champ_debut = new Collection\Entity\Champ('Début de période', $type_artefact_logiciel, 'date');
		$champ_debut->__set('description', 'Date du début de la période standard d\'utilisation du logiciel');
		
		$champ_fin = new Collection\Entity\Champ('Fin de période', $type_artefact_logiciel, 'date');
		$champ_fin->__set('description', 'Date du début de la période standard d\'utilisation du logiciel');
		
		$manager->persist($type_artefact_logiciel);
		$manager->persist($champ_editeur);
		$manager->persist($champ_auteur);
		$manager->persist($champ_langage);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		$manager->flush();
		
		/*
		 * Artefact : Document
		 */
		$type_artefact_document = new Collection\Entity\TypeElement('Document', 'artefact');
		
		$champ_editeur = new Collection\Entity\Champ('Editeur', $type_artefact_document, 'texte');
		$champ_editeur->__set('description', 'L\'éditeur du document');
		
		$champ_auteur = new Collection\Entity\Champ('Auteur(s)', $type_artefact_document, 'texte');
		$champ_auteur->__set('description', 'Le (les) auteur(s) du document, personne(s) ou société(s)');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_artefact_document, 'date');
		$champ_date->__set('description', 'Date de parution du document');
		
		$manager->persist($type_artefact_document);
		$manager->persist($champ_editeur);
		$manager->persist($champ_auteur);
		$manager->persist($champ_date);
		$manager->flush();
		
		/*
		 * Artefact : Institution
		 */
		$type_artefact_institution = new Collection\Entity\TypeElement('Institution', 'artefact');
		
		$champ_debut = new Collection\Entity\Champ('Création', $type_artefact_institution, 'date');
		$champ_debut->__set('description', 'Date du création de l\'institution');
		
		$champ_fin = new Collection\Entity\Champ('Fin', $type_artefact_institution, 'date');
		$champ_fin->__set('description', 'Date de disparition de l\'institution');
		
		$champ_adresse = new Collection\Entity\Champ('Adresse(s)', $type_artefact_institution, 'texte');
		$champ_adresse->__set('description', 'La (les) adresse(s) des implantations de l\'institution');
		
		$manager->persist($type_artefact_institution);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		$manager->persist($champ_adresse);
		$manager->flush();
		
		/*
		 * Artefact : Lieu
		 */
		$type_artefact_lieu = new Collection\Entity\TypeElement('Lieu', 'artefact');
		
		$champ_adresse = new Collection\Entity\Champ('Adresse', $type_artefact_lieu, 'texte');
		$champ_adresse->__set('description', 'L\'adresse du lieu');
		
		$manager->persist($type_artefact_lieu);
		$manager->persist($champ_adresse);
		$manager->flush();
		
		/*
		 * Artefact : Personne
		 */
		$type_artefact_personne = new Collection\Entity\TypeElement('Personne', 'artefact');
		
		$champ_nationnalite = new Collection\Entity\Champ('Nationnalité', $type_artefact_personne, 'texte');
		$champ_nationnalite->__set('description', 'La nationnalité de la personne');
		
		$champ_naissance = new Collection\Entity\Champ('Date de naissance', $type_artefact_personne, 'date');
		$champ_naissance->__set('description', 'La date de naissance de la personne');
		
		$champ_deces = new Collection\Entity\Champ('Date de décès', $type_artefact_personne, 'date');
		$champ_deces->__set('description', 'La date de décès de la personne');
		
		$manager->persist($type_artefact_personne);
		$manager->persist($champ_nationnalite);
		$manager->persist($champ_naissance);
		$manager->persist($champ_deces);
		$manager->flush();
		
		/*
		 * Artefact : Projet
		 */
		$type_artefact_projet = new Collection\Entity\TypeElement('Projet','artefact');
		
		$champ_acteurs = new Collection\Entity\Champ('Acteurs', $type_artefact_projet, 'texte');
		$champ_acteurs->__set('description', 'Les acteurs du projet, personnes ou entit�s');
		
		$champ_debut = new Collection\Entity\Champ('Début', $type_artefact_projet, 'date');
		$champ_debut->__set('description', 'La date de début du projet');
		
		$champ_fin = new Collection\Entity\Champ('Fin', $type_artefact_projet,  'date');
		$champ_fin->__set('description', 'La date de fin du projet');
		
		$manager->persist($type_artefact_projet);
		$manager->persist($champ_acteurs);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		$manager->flush();
		
		/*
		 * Artefact : Evenement
		*/
		$type_artefact_evenement = new Collection\Entity\TypeElement('Evènement', 'artefact');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_artefact_evenement, 'date');
		$champ_date->__set('description', 'La date de l\'évènement');
		
		$champ_adresse = new Collection\Entity\Champ('Adresse', $type_artefact_evenement, 'texte');
		$champ_adresse->__set('description', 'L\'adresse de l\'évènement');
		
		$champ_organisateurs = new Collection\Entity\Champ('Organisateurs', $type_artefact_evenement, 'texte');
		$champ_organisateurs->__set('description', 'Les organisateurs de l\'évènement, personnes ou entités');
		
		$champ_participants = new Collection\Entity\Champ('Participants', $type_artefact_evenement, 'texte');
		$champ_participants->__set('description', 'Les personnes ou entités ayant participé à l\'évènement');
	
		$manager->persist($type_artefact_evenement);
		$manager->persist($champ_date);
		$manager->persist($champ_adresse);
		$manager->persist($champ_organisateurs);
		$manager->persist($champ_participants);
		$manager->flush();
		
		/*
		 * Artefact : Site Web
		*/
		$type_artefact_site = new Collection\Entity\TypeElement('Site Web', 'artefact');
		
		$champ_url = new Collection\Entity\Champ('Date', $type_artefact_site, 'date');
		$champ_url->__set('description', 'L\'adresse url du site web');
		
		$manager->persist($type_artefact_site);
		$manager->persist($champ_url);
		$manager->flush();
		
		/*
		 * Artefact : Autre
		*/
		$type_artefact_autre = new Collection\Entity\TypeElement('Autre', 'artefact');
		
		$champ_type = new Collection\Entity\Champ('Type d\'artefact', $type_artefact_autre, 'texte');
		$champ_type->__set('description', 'Le type d\entité que représente l\'artefact');
		
		$manager->persist($type_artefact_autre);
		$manager->persist($champ_type);
		$manager->flush();
		
	
		
		/* ***************************** *
		 * QUELQUES INSANCES D'ARTEFACTS *
		* ****************************** */
		
		/*
		 * Un mat�riel
		 */
		$calc = new Collection\Entity\Artefact('Calculatrice', $type_artefact_materiel);
		$calc->__set('description', 'Machine à calculer mécanique');
		$manager->persist($calc);
		
		$champ_fabriquant = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fabriquant', 'type_element'=>$type_artefact_materiel));
		if ($champ_fabriquant == null) {
			throw new Exception('Champ "fabriquant" de l\'artefact mat�riel non trouv�');
		}
		$data_fabriquant = new Collection\Entity\Data($calc, $champ_fabriquant);
		$data_fabriquant->__set('texte', 'Inconnu');
		$manager->persist($data_fabriquant);
		
		$champ_debut = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Début de période', 'type_element'=>$type_artefact_materiel));
		if ($champ_debut == null) {
			throw new Exception('Champ "début" de l\'artefact matériel non trouvé');
		}
		$data_debut = new Collection\Entity\Data($calc, $champ_debut);
		$data_debut->__set('date', new DateTime('1925-01-01'));
		$manager->persist($data_debut);
		
		$champ_fin = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fin de période', 'type_element'=>$type_artefact_materiel));
		if ($champ_fin == null) {
			throw new Exception('Champ "fin" de l\'artefact matériel non trouvé');
		}
		$data_fin = new Collection\Entity\Data($calc, $champ_fin);
		$data_fin->__set('date', new DateTime('1950-01-01'));
		$manager->persist($data_fin);
		
		$manager->flush();
		
		/*
		 * Une personne
		*/
		$vauc = new Collection\Entity\Artefact('Jacques de Vaucanson', $type_artefact_personne);
		$vauc->__set('description', 'Jacques de Vaucanson, né le 24 février 1709 à Grenoble et mort le 21 novembre 1782 à Paris, est un inventeur et mécanicien français. Il a inventé plusieurs automates.');
		$manager->persist($vauc);
		
		$champ_nationnalite = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Nationnalité', 'type_element'=>$type_artefact_personne));
		if ($champ_fabriquant == null) {
			throw new Exception('Champ "nationnalité" de l\'artefact personne non trouvé');
		}
		$data_nationnalite = new Collection\Entity\Data($vauc, $champ_nationnalite);
		$data_nationnalite->__set('texte', 'Français');
		$manager->persist($data_nationnalite);
		
		$champ_naissance = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date de naissance', 'type_element'=>$type_artefact_personne));
		if ($champ_debut == null) {
			throw new Exception('Champ "naissance" de l\'artefact personne non trouvé');
		}
		$data_naissance = new Collection\Entity\Data($vauc, $champ_naissance);
		$data_naissance->__set('date', new DateTime('1709-02-24'));
		$manager->persist($data_naissance);
		
		$champ_deces = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date de décès', 'type_element'=>$type_artefact_personne));
		if ($champ_fin == null) {
			throw new Exception('Champ "deces" de l\'artefact personne non trouvé');
		}
		$data_deces = new Collection\Entity\Data($vauc, $champ_deces);
		$data_deces->__set('date', new DateTime('1782-11-21'));
		$manager->persist($data_deces);
		
		$manager->flush();
		
	}
}
