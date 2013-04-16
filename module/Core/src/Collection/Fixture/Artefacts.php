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
		 * Artefact : Mat�riel
		 */
		$type_artefact_materiel = new Collection\Entity\TypeElement();
		$type_artefact_materiel->__set('nom', 'Mat�riel');
		$type_artefact_materiel->__set('type', 'artefact');
		
		$champ_fabriquant = new Collection\Entity\Champ();
		$champ_fabriquant->__set('label', 'Fabriquant');
		$champ_fabriquant->__set('description', 'La soci�t� qui fabrique ce mat�riel');
		$champ_fabriquant->__set('format', 'texte');
		$champ_fabriquant->__set('type_element', $type_artefact_materiel);
		
		$champ_debut = new Collection\Entity\Champ();
		$champ_debut->__set('label', 'D�but de p�riode');
		$champ_debut->__set('description', 'Date du d�but de la p�riode standard d\'utilisation du mat�riel');
		$champ_debut->__set('format', 'date');
		$champ_debut->__set('type_element', $type_artefact_materiel);
		
		$champ_fin = new Collection\Entity\Champ();
		$champ_fin->__set('label', 'Fin de p�riode');
		$champ_fin->__set('description', 'Date du d�but de la p�riode standard d\'utilisation du mat�riel');
		$champ_fin->__set('format', 'date');
		$champ_fin->__set('type_element', $type_artefact_materiel);
		
		$manager->persist($type_artefact_materiel);
		$manager->persist($champ_fabriquant);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		$manager->flush();
		
		/*
		 * Artefact : Logiciel
		 */
		$type_artefact_logiciel = new Collection\Entity\TypeElement();
		$type_artefact_logiciel->__set('nom', 'Logiciel');
		$type_artefact_logiciel->__set('type', 'artefact');
		
		$champ_editeur = new Collection\Entity\Champ();
		$champ_editeur->__set('label', 'Editeur');
		$champ_editeur->__set('description', 'L\'�diteur du logiciel');
		$champ_editeur->__set('format', 'texte');
		$champ_editeur->__set('type_element', $type_artefact_logiciel);

		$champ_auteur = new Collection\Entity\Champ();
		$champ_auteur->__set('label', 'Auteur(s)');
		$champ_auteur->__set('description', 'Le (les) auteur(s) du logiciel, personne(s) ou soci�t�(s)');
		$champ_auteur->__set('format', 'texte');
		$champ_auteur->__set('type_element', $type_artefact_logiciel);
		
		$champ_langage = new Collection\Entity\Champ();
		$champ_langage->__set('label', 'Langages de programmation');
		$champ_langage->__set('description', 'Les principaux languages de programmation utilis�s dans le code du logiciel');
		$champ_langage->__set('format', 'texte');
		$champ_langage->__set('type_element', $type_artefact_logiciel);
		
		$champ_debut = new Collection\Entity\Champ();
		$champ_debut->__set('label', 'D�but de p�riode');
		$champ_debut->__set('description', 'Date du d�but de la p�riode standard d\'utilisation du logiciel');
		$champ_debut->__set('format', 'date');
		$champ_debut->__set('type_element', $type_artefact_logiciel);
		
		$champ_fin = new Collection\Entity\Champ();
		$champ_fin->__set('label', 'Fin de p�riode');
		$champ_fin->__set('description', 'Date du d�but de la p�riode standard d\'utilisation du logiciel');
		$champ_fin->__set('format', 'date');
		$champ_fin->__set('type_element', $type_artefact_logiciel);
		
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
		$type_artefact_document = new Collection\Entity\TypeElement();
		$type_artefact_document->__set('nom', 'Document');
		$type_artefact_document->__set('type', 'artefact');
		
		$champ_editeur = new Collection\Entity\Champ();
		$champ_editeur->__set('label', 'Editeur');
		$champ_editeur->__set('description', 'L\'�diteur du document');
		$champ_editeur->__set('format', 'texte');
		$champ_editeur->__set('type_element', $type_artefact_document);
		
		$champ_auteur = new Collection\Entity\Champ();
		$champ_auteur->__set('label', 'Auteur(s)');
		$champ_auteur->__set('description', 'Le (les) auteur(s) du document, personne(s) ou soci�t�(s)');
		$champ_auteur->__set('format', 'texte');
		$champ_auteur->__set('type_element', $type_artefact_document);
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'Date de parution du document');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_artefact_document);
		
		$manager->persist($type_artefact_document);
		$manager->persist($champ_editeur);
		$manager->persist($champ_auteur);
		$manager->persist($champ_date);
		$manager->flush();
		
		/*
		 * Artefact : Institution
		 */
		$type_artefact_institution = new Collection\Entity\TypeElement();
		$type_artefact_institution->__set('nom', 'Institution');
		$type_artefact_institution->__set('type', 'artefact');
		
		$champ_debut = new Collection\Entity\Champ();
		$champ_debut->__set('label', 'Cr�ation');
		$champ_debut->__set('description', 'Date du cr�ation de l\'institution');
		$champ_debut->__set('format', 'date');
		$champ_debut->__set('type_element', $type_artefact_institution);
		
		$champ_fin = new Collection\Entity\Champ();
		$champ_fin->__set('label', 'Fin');
		$champ_fin->__set('description', 'Date de disparition de l\'institution');
		$champ_fin->__set('format', 'date');
		$champ_fin->__set('type_element', $type_artefact_institution);
		
		$champ_adresse = new Collection\Entity\Champ();
		$champ_adresse->__set('label', 'Adresse(s)');
		$champ_adresse->__set('description', 'La (les) adresse(s) des implantations de l\'institution');
		$champ_adresse->__set('format', 'texte');
		$champ_adresse->__set('type_element', $type_artefact_institution);
		
		$manager->persist($type_artefact_institution);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		$manager->persist($champ_adresse);
		$manager->flush();
		
		/*
		 * Artefact : Lieu
		 */
		$type_artefact_lieu = new Collection\Entity\TypeElement();
		$type_artefact_lieu->__set('nom', 'Lieu');
		$type_artefact_lieu->__set('type', 'artefact');
		
		$champ_adresse = new Collection\Entity\Champ();
		$champ_adresse->__set('label', 'Adresse');
		$champ_adresse->__set('description', 'L\'adresse du lieu');
		$champ_adresse->__set('format', 'texte');
		$champ_adresse->__set('type_element', $type_artefact_lieu);
		
		$manager->persist($type_artefact_lieu);
		$manager->persist($champ_adresse);
		$manager->flush();
		
		/*
		 * Artefact : Personne
		 */
		$type_artefact_personne = new Collection\Entity\TypeElement();
		$type_artefact_personne->__set('nom', 'Personne');
		$type_artefact_personne->__set('type', 'artefact');
		
		$champ_nationnalite = new Collection\Entity\Champ();
		$champ_nationnalite->__set('label', 'Nationnalit�');
		$champ_nationnalite->__set('description', 'La nationnalit� de la personne');
		$champ_nationnalite->__set('format', 'texte');
		$champ_nationnalite->__set('type_element', $type_artefact_personne);
		
		$champ_naissance = new Collection\Entity\Champ();
		$champ_naissance->__set('label', 'Date de naissance');
		$champ_naissance->__set('description', 'La date de naissance de la personne');
		$champ_naissance->__set('format', 'date');
		$champ_naissance->__set('type_element', $type_artefact_personne);
		
		$champ_deces = new Collection\Entity\Champ();
		$champ_deces->__set('label', 'Date de d�c�s');
		$champ_deces->__set('description', 'La date de d�c�s de la personne');
		$champ_deces->__set('format', 'date');
		$champ_deces->__set('type_element', $type_artefact_personne);
		
		$manager->persist($type_artefact_personne);
		$manager->persist($champ_nationnalite);
		$manager->persist($champ_naissance);
		$manager->persist($champ_deces);
		$manager->flush();
		
		/*
		 * Artefact : Projet
		 */
		$type_artefact_projet = new Collection\Entity\TypeElement();
		$type_artefact_projet->__set('nom', 'Projet');
		$type_artefact_projet->__set('type', 'artefact');
		
		$champ_acteurs = new Collection\Entity\Champ();
		$champ_acteurs->__set('label', 'Acteurs');
		$champ_acteurs->__set('description', 'Les acteurs du projet, personnes ou entit�s');
		$champ_acteurs->__set('format', 'texte');
		$champ_acteurs->__set('type_element', $type_artefact_projet);
		
		$champ_debut = new Collection\Entity\Champ();
		$champ_debut->__set('label', 'D�but');
		$champ_debut->__set('description', 'La date de d�but du projet');
		$champ_debut->__set('format', 'date');
		$champ_debut->__set('type_element', $type_artefact_projet);
		
		$champ_fin = new Collection\Entity\Champ();
		$champ_fin->__set('label', 'Fin');
		$champ_fin->__set('description', 'La date de fin du projet');
		$champ_fin->__set('format', 'date');
		$champ_fin->__set('type_element', $type_artefact_projet);
		
		$manager->persist($type_artefact_projet);
		$manager->persist($champ_acteurs);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		$manager->flush();
		
		/*
		 * Artefact : Evenement
		*/
		$type_artefact_evenement = new Collection\Entity\TypeElement();
		$type_artefact_evenement->__set('nom', 'Ev�nement');
		$type_artefact_evenement->__set('type', 'artefact');
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'La date de l\'�v�nement');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_artefact_evenement);
		
		$champ_adresse = new Collection\Entity\Champ();
		$champ_adresse->__set('label', 'Adresse');
		$champ_adresse->__set('description', 'L\'adresse de l\'�v�nement');
		$champ_adresse->__set('format', 'texte');
		$champ_adresse->__set('type_element', $type_artefact_evenement);
		
		$champ_organisateurs = new Collection\Entity\Champ();
		$champ_organisateurs->__set('label', 'Organisateurs');
		$champ_organisateurs->__set('description', 'Les organisateurs de l\'�v�nement, personnes ou entit�s');
		$champ_organisateurs->__set('format', 'texte');
		$champ_organisateurs->__set('type_element', $type_artefact_evenement);
		
		$champ_participants = new Collection\Entity\Champ();
		$champ_participants->__set('label', 'Participants');
		$champ_participants->__set('description', 'Les personnes ou entit�s ayant particip� � l\'�v�nement');
		$champ_participants->__set('format', 'texte');
		$champ_participants->__set('type_element', $type_artefact_evenement);
	
		$manager->persist($type_artefact_evenement);
		$manager->persist($champ_date);
		$manager->persist($champ_adresse);
		$manager->persist($champ_organisateurs);
		$manager->persist($champ_participants);
		$manager->flush();
		
		/*
		 * Artefact : Site Web
		*/
		$type_artefact_site = new Collection\Entity\TypeElement();
		$type_artefact_site->__set('nom', 'Site Web');
		$type_artefact_site->__set('type', 'artefact');
		
		$champ_url = new Collection\Entity\Champ();
		$champ_url->__set('label', 'Date');
		$champ_url->__set('description', 'L\'adresse url du site web');
		$champ_url->__set('format', 'date');
		$champ_url->__set('type_element', $type_artefact_site);
		
		$manager->persist($type_artefact_site);
		$manager->persist($champ_url);
		$manager->flush();
		
		/*
		 * Artefact : Autre
		*/
		$type_artefact_autre = new Collection\Entity\TypeElement();
		$type_artefact_autre->__set('nom', 'Autre');
		$type_artefact_autre->__set('type', 'artefact');
		
		$champ_type = new Collection\Entity\Champ();
		$champ_type->__set('label', 'Type d\'artefact');
		$champ_type->__set('description', 'Le type d\entit� que repr�sente l\'artefact');
		$champ_type->__set('format', 'date');
		$champ_type->__set('type_element', $type_artefact_autre);
		
		$manager->persist($type_artefact_autre);
		$manager->persist($champ_type);
		$manager->flush();
		
		
		/* ***************************************** *
		 * SEMANTIQUES DES RELATIONS ENTRE ARTEFACTS *
		* ****************************************** */
		
		/*
		 * On r�cup�re les diff�rents types d'artefacts
		 */
		$type_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Mat�riel', 'type' => 'artefact'));
		if ($type_materiel == null) {
			throw new Exception('TypeElement \'Materiel\' non trouv�');
		}
		$type_logiciel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Logiciel', 'type' => 'artefact'));
		if ($type_logiciel == null) {
			throw new Exception('TypeElement \'Logiciel\' non trouv�');
		}
		$type_document = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Document', 'type' => 'artefact'));
		if ($type_document == null) {
			throw new Exception('TypeElement \'Document\' non trouv�');
		}
		$type_institution = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Institution', 'type' => 'artefact'));
		if ($type_institution == null) {
			throw new Exception('TypeElement \'Institution\' non trouv�');
		}
		$type_lieu = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Lieu', 'type' => 'artefact'));
		if ($type_lieu == null) {
			throw new Exception('TypeElement \'Lieu\' non trouv�');
		}
		$type_personne = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Personne', 'type' => 'artefact'));
		if ($type_personne == null) {
			throw new Exception('TypeElement \'Personne\' non trouv�');
		}
		$type_projet = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Projet', 'type' => 'artefact'));
		if ($type_projet == null) {
			throw new Exception('TypeElement \'Projet\' non trouv�');
		}
		$type_evenement = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Ev�nement', 'type' => 'artefact'));
		if ($type_evenement == null) {
			throw new Exception('TypeElement \'Evenement\' non trouv�');
		}
		$type_siteweb = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Site Web', 'type' => 'artefact'));
		if ($type_siteweb == null) {
			throw new Exception('TypeElement \'Site Web\' non trouv�');
		}
		$type_autre = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Autre', 'type' => 'artefact'));
		if ($type_autre == null) {
			throw new Exception('TypeElement \'Autre\' non trouv�');
		}
		
		/*
		 * S�mantiques de la relation mat�riel->mat�riel
		 */
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Est compos� de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Est une partie de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation mat�riel->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation mat�riel->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation mat�riel->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est utilis� par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est fabriqu�e par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation mat�riel->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Est invent�e �');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Est stock�e �');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation mat�riel->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Est invent�e par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation mat�riel->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Est utilis� dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation mat�riel->ev�nement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation mat�riel->siteweb
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();

		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation mat�riel->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->mat�riel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Est utilis� par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Est une partie de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Est compos�e de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est utilis� par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est publie par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Est �crit par');
		$manager->persist($semantique);
		$manager->flush();

		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Est utilis� dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->evenement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->siteweb
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation logiciel->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_logiciel);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->materiel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est puli� par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est publi� par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Est �crit par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->evenement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->siteweb
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation document->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_document);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();

		/*
		 * S�mantiques de la relation institution->materiel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Fabrique');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation institution->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Publie');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation institution->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Est d�crite dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Publie');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation institution->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est partenaire de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation institution->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Est situ�e �');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation institution->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'A pour membre');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'A pour fondateur');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation institution->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'M�ne');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Finance');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Participe �');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation institution->evenement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Organise');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Participe �');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation institution->siteweb
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Est d�crite dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'A mis en ligne');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation institution->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_institution);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->materiel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Est l\'endroit o� est invent�');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Est l\'endroit o� est stock�e');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est l\'endroit o� se situe');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Est l\'endroit o� est n�');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Est l\'endroit o� est d�c�d�');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->evenement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Est l\'endroit o� a eu lieu');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->siteweb
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation lieu->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_lieu);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->materiel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Invente');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Est auteur de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Est auteur de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est membre de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'A fond�');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Est n� �');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Est d�c�d� �');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Est de la famille de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Est membre de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Est chef de');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->evenement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Participe �');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Organise');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->siteweb
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Est d�crite dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation personne->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_personne);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->mat�riel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est men�e par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est financ� par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'A pour participant');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'A pour membre');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'A pour chef');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Est un sous-projet de');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'A pour sous projet');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->evenement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->siteweb
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation projet->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_projet);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->materiel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Est organis� par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'A pour participant');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'A lieu �');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Est organis� par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'A pour participant');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->evenement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->siteweb
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation evenement->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_evenement);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->materiel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Est d�crit dans');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'A �t� mis en ligne par');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->evenement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'D�crit');
		$manager->persist($semantique);
		$manager->flush();
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->siteweb
		*/		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation siteweb->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_siteweb);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->mat�riel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_materiel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->logiciel
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->document
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_document);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->institution
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_institution);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->lieu
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_lieu);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->personne
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_personne);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->projet
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_projet);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->eenement
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_evenement);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->siteweb
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_siteweb);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		/*
		 * S�mantiques de la relation autre->autre
		*/
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_autre);
		$semantique->__set('type_destination', $type_autre);
		$semantique->__set('semantique', 'Autre');
		$manager->persist($semantique);
		$manager->flush();
		
		
		/* ***************************** *
		 * QUELQUES INSANCES D'ARTEFACTS *
		* ****************************** */
		
		/*
		 * Un mat�riel
		 */
		$calc = new Collection\Entity\Artefact();
		$calc->__set('titre', 'Calculatrice');
		$calc->__set('description', 'Machine � calculer m�canique');
		$calc->__set('type_element', $type_materiel);
		$manager->persist($calc);
		
		$champ_fabriquant = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fabriquant', 'type_element'=>$type_materiel));
		if ($champ_fabriquant == null) {
			throw new Exception('Champ "fabriquant" de l\'artefact mat�riel non trouv�');
		}
		$data_fabriquant = new Collection\Entity\Data();
		$data_fabriquant->__set('champ', $champ_fabriquant);
		$data_fabriquant->__set('element', $calc);
		$data_fabriquant->__set('texte', 'Inconnu');
		$manager->persist($data_fabriquant);
		
		$champ_debut = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'D�but de p�riode', 'type_element'=>$type_materiel));
		if ($champ_debut == null) {
			throw new Exception('Champ "d�but" de l\'artefact mat�riel non trouv�');
		}
		$data_debut = new Collection\Entity\Data();
		$data_debut->__set('champ', $champ_debut);
		$data_debut->__set('element', $calc);
		$data_debut->__set('date', new DateTime('1925-01-01'));
		$manager->persist($data_debut);
		
		$champ_fin = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fin de p�riode', 'type_element'=>$type_materiel));
		if ($champ_fin == null) {
			throw new Exception('Champ "fin" de l\'artefact mat�riel non trouv�');
		}
		$data_fin = new Collection\Entity\Data();
		$data_fin->__set('champ', $champ_fin);
		$data_fin->__set('element', $calc);
		$data_fin->__set('date', new DateTime('1950-01-01'));
		$manager->persist($data_fin);
		
		$manager->flush();
		
		/*
		 * Une personne
		*/
		$vauc = new Collection\Entity\Artefact();
		$vauc->__set('titre', 'Jacques de Vaucanson');
		$vauc->__set('description', 'Jacques de Vaucanson, n� le 24 f�vrier 1709 � Grenoble et mort le 21 novembre 1782 � Paris, est un inventeur et m�canicien fran�ais. Il a invent� plusieurs automates.');
		$vauc->__set('type_element', $type_personne);
		$manager->persist($vauc);
		
		$champ_nationnalite = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Nationnalit�', 'type_element'=>$type_personne));
		if ($champ_fabriquant == null) {
			throw new Exception('Champ "nationnalit�" de l\'artefact personne non trouv�');
		}
		$data_nationnalite = new Collection\Entity\Data();
		$data_nationnalite->__set('champ', $champ_nationnalite);
		$data_nationnalite->__set('element', $vauc);
		$data_nationnalite->__set('texte', 'Fran�ais');
		$manager->persist($data_nationnalite);
		
		$champ_naissance = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'D�but denaissance', 'type_element'=>$type_personne));
		if ($champ_debut == null) {
			throw new Exception('Champ "naissance" de l\'artefact mat�riel non trouv�');
		}
		$data_naissance = new Collection\Entity\Data();
		$data_naissance->__set('champ', $champ_naissance);
		$data_naissance->__set('element', $vauc);
		$data_naissance->__set('date', new DateTime('1709-02-24'));
		$manager->persist($data_naissance);
		
		$champ_deces = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date de d�c�s', 'type_element'=>$type_personne));
		if ($champ_fin == null) {
			throw new Exception('Champ "deces" de l\'artefact personne non trouv�');
		}
		$data_deces = new Collection\Entity\Data();
		$data_deces->__set('champ', $champ_deces);
		$data_deces->__set('element', $vauc);
		$data_deces->__set('date', new DateTime('1782-11-21'));
		$manager->persist($data_deces);
		
		$manager->flush();
		
	}
}
