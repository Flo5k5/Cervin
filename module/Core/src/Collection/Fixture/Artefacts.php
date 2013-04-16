<?php


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Artefacts implements FixtureInterface
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
		$type_artefact_materiel = new Collection\Entity\TypeElement();
		$type_artefact_materiel->__set('nom', 'Matériel');
		$type_artefact_materiel->__set('type', 'artefact');
		
		$champ_label = new Collection\Entity\Champ();
		$champ_label->__set('label', 'Fabriquant');
		$champ_label->__set('description', 'La société qui fabrique ce matériel');
		$champ_label->__set('format', 'texte');
		$champ_label->__set('type_element', $type_artefact_materiel);
		
		$champ_debut = new Collection\Entity\Champ();
		$champ_debut->__set('label', 'Début de période');
		$champ_debut->__set('description', 'Date du début de la période standard d\'utilisation du matériel');
		$champ_debut->__set('format', 'date');
		$champ_debut->__set('type_element', $type_artefact_materiel);
		
		$champ_fin = new Collection\Entity\Champ();
		$champ_fin->__set('label', 'Fin de période');
		$champ_fin->__set('description', 'Date du début de la période standard d\'utilisation du matériel');
		$champ_fin->__set('format', 'date');
		$champ_fin->__set('type_element', $type_artefact_materiel);
		
		$manager->persist($type_artefact_materiel);
		$manager->persist($champ_label);
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
		$champ_editeur->__set('description', 'L\'éditeur du logiciel');
		$champ_editeur->__set('format', 'texte');
		$champ_editeur->__set('type_element', $type_artefact_logiciel);

		$champ_auteur = new Collection\Entity\Champ();
		$champ_auteur->__set('label', 'Auteur(s)');
		$champ_auteur->__set('description', 'Le (les) auteur(s) du logiciel, personne(s) ou société(s)');
		$champ_auteur->__set('format', 'texte');
		$champ_auteur->__set('type_element', $type_artefact_logiciel);
		
		$champ_langage = new Collection\Entity\Champ();
		$champ_langage->__set('label', 'Langages de programmation');
		$champ_langage->__set('description', 'Les principaux languages de programmation utilisés dans le code du logiciel');
		$champ_langage->__set('format', 'texte');
		$champ_langage->__set('type_element', $type_artefact_logiciel);
		
		$champ_debut = new Collection\Entity\Champ();
		$champ_debut->__set('label', 'Début de période');
		$champ_debut->__set('description', 'Date du début de la période standard d\'utilisation du logiciel');
		$champ_debut->__set('format', 'date');
		$champ_debut->__set('type_element', $type_artefact_logiciel);
		
		$champ_fin = new Collection\Entity\Champ();
		$champ_fin->__set('label', 'Fin de période');
		$champ_fin->__set('description', 'Date du début de la période standard d\'utilisation du logiciel');
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
		$champ_editeur->__set('description', 'L\'éditeur du document');
		$champ_editeur->__set('format', 'texte');
		$champ_editeur->__set('type_element', $type_artefact_document);
		
		$champ_auteur = new Collection\Entity\Champ();
		$champ_auteur->__set('label', 'Auteur(s)');
		$champ_auteur->__set('description', 'Le (les) auteur(s) du document, personne(s) ou société(s)');
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
		$champ_debut->__set('label', 'Création');
		$champ_debut->__set('description', 'Date du création de l\'institution');
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
		$champ_nationnalite->__set('label', 'Nationnalité');
		$champ_nationnalite->__set('description', 'La nationnalité de la personne');
		$champ_nationnalite->__set('format', 'texte');
		$champ_nationnalite->__set('type_element', $type_artefact_personne);
		
		$champ_naissance = new Collection\Entity\Champ();
		$champ_naissance->__set('label', 'Date de naissance');
		$champ_naissance->__set('description', 'La date de naissance de la personne');
		$champ_naissance->__set('format', 'date');
		$champ_naissance->__set('type_element', $type_artefact_personne);
		
		$champ_deces = new Collection\Entity\Champ();
		$champ_deces->__set('label', 'Date de décès');
		$champ_deces->__set('description', 'La date de décès de la personne');
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
		$champ_acteurs->__set('description', 'Les acteurs du projet, personnes ou entités');
		$champ_acteurs->__set('format', 'texte');
		$champ_acteurs->__set('type_element', $type_artefact_projet);
		
		$champ_debut = new Collection\Entity\Champ();
		$champ_debut->__set('label', 'Début');
		$champ_debut->__set('description', 'La date de début du projet');
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
		$type_artefact_evenement->__set('nom', 'Evènement');
		$type_artefact_evenement->__set('type', 'artefact');
		
		$champ_date = new Collection\Entity\Champ();
		$champ_date->__set('label', 'Date');
		$champ_date->__set('description', 'La date de l\'évènement');
		$champ_date->__set('format', 'date');
		$champ_date->__set('type_element', $type_artefact_evenement);
		
		$champ_adresse = new Collection\Entity\Champ();
		$champ_adresse->__set('label', 'Adresse');
		$champ_adresse->__set('description', 'L\'adresse de l\'évènement');
		$champ_adresse->__set('format', 'texte');
		$champ_adresse->__set('type_element', $type_artefact_evenement);
		
		$champ_organisateurs = new Collection\Entity\Champ();
		$champ_organisateurs->__set('label', 'Organisateurs');
		$champ_organisateurs->__set('description', 'Les organisateurs de l\'évènement, personnes ou entités');
		$champ_organisateurs->__set('format', 'texte');
		$champ_organisateurs->__set('type_element', $type_artefact_evenement);
		
		$champ_participants = new Collection\Entity\Champ();
		$champ_participants->__set('label', 'Participants');
		$champ_participants->__set('description', 'Les personnes ou entités ayant participé à l\'évènement');
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
		$champ_type->__set('description', 'Le type d\entité que représente l\'artefact');
		$champ_type->__set('format', 'date');
		$champ_type->__set('type_element', $type_artefact_autre);
		
		$manager->persist($type_artefact_autre);
		$manager->persist($champ_type);
		$manager->flush();
		
		
		/* ***************************************** *
		 * SEMANTIQUES DES RELATIONS ENTRE ARTEFACTS *
		* ****************************************** */
		
		$type_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Matériel', 'type' => 'artefact'));
		if ($type_materiel == null) {
			throw new Exception('TypeElement \'Matériel\' non trouvé');
		}
		$type_logiciel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom' => 'Logiciel', 'type' => 'artefact'));

		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_materiel);
		$semantique->__set('type_destination', $type_logiciel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		$manager->flush();
		
	}
}
