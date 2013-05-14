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
		$champ_fabriquant->__set('description', 'La société qui fabrique ce matériel');
		
		$champ_debut = new Collection\Entity\Champ('Début de période', $type_artefact_materiel, 'date');
		$champ_debut->__set('description', 'Date du début de la période standard d\'utilisation du matériel');
		
		$champ_fin = new Collection\Entity\Champ('Fin de période', $type_artefact_materiel, 'date');
		$champ_fin->__set('description', 'Date du début de la période standard d\'utilisation du matériel');
		
		$manager->persist($type_artefact_materiel);
		$manager->persist($champ_fabriquant);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		
		/*
		 * Artefact : Logiciel
		 */
		$type_artefact_logiciel = new Collection\Entity\TypeElement('Logiciel', 'artefact');
		
		$champ_editeur = new Collection\Entity\Champ('Editeur', $type_artefact_logiciel, 'texte');
		$champ_editeur->__set('description', 'L\'éditeur du logiciel');

		$champ_auteur = new Collection\Entity\Champ('Auteur(s)', $type_artefact_logiciel, 'texte');
		$champ_auteur->__set('description', 'Le (les) auteur(s) du logiciel, personne(s) ou société(s)');
		
		$champ_langage = new Collection\Entity\Champ('Langages', $type_artefact_logiciel, 'texte');
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
		
		/*
		 * Artefact : Lieu
		 */
		$type_artefact_lieu = new Collection\Entity\TypeElement('Lieu', 'artefact');
		
		$champ_adresse = new Collection\Entity\Champ('Adresse', $type_artefact_lieu, 'texte');
		$champ_adresse->__set('description', 'L\'adresse du lieu');
		
		$manager->persist($type_artefact_lieu);
		$manager->persist($champ_adresse);
		
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
		
		/*
		 * Artefact : Projet
		 */
		$type_artefact_projet = new Collection\Entity\TypeElement('Projet','artefact');
		
		$champ_acteurs = new Collection\Entity\Champ('Acteurs', $type_artefact_projet, 'texte');
		$champ_acteurs->__set('description', 'Les acteurs du projet, personnes ou entités');
		
		$champ_debut = new Collection\Entity\Champ('Début', $type_artefact_projet, 'date');
		$champ_debut->__set('description', 'La date de début du projet');
		
		$champ_fin = new Collection\Entity\Champ('Fin', $type_artefact_projet,  'date');
		$champ_fin->__set('description', 'La date de fin du projet');
		
		$manager->persist($type_artefact_projet);
		$manager->persist($champ_acteurs);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		
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
		
		/*
		 * Artefact : Site Web
		*/
		$type_artefact_site = new Collection\Entity\TypeElement('Site Web', 'artefact');
		
		$champ_url = new Collection\Entity\Champ('Date', $type_artefact_site, 'date');
		$champ_url->__set('description', 'L\'adresse url du site web');
		
		$manager->persist($type_artefact_site);
		$manager->persist($champ_url);
		
		/*
		 * Artefact : Autre
		*/
		$type_artefact_autre = new Collection\Entity\TypeElement('Autre', 'artefact');
		
		$champ_type = new Collection\Entity\Champ('Type d\'artefact', $type_artefact_autre, 'texte');
		$champ_type->__set('description', 'Le type d\'entité que représente l\'artefact');
		
		$manager->persist($type_artefact_autre);
		$manager->persist($champ_type);
		
		$manager->flush();
		
		/*
		 * Artefact : Test démo
		*/
		$type_artefact_test = new Collection\Entity\TypeElement('Test démo', 'artefact');
		
		$champ_texte = new Collection\Entity\Champ('Label texte', $type_artefact_test, 'texte');
		$champ_texte->__set('description', 'Description du champ texte');
		
		$champ_textarea = new Collection\Entity\Champ('Label textarea', $type_artefact_test, 'textarea');
		$champ_textarea->__set('description', 'Description du champ textarea');
		
		$champ_nombre = new Collection\Entity\Champ('Label nombre', $type_artefact_test, 'nombre');
		$champ_nombre->__set('description', 'Description du champ nombre');
		
		$champ_date = new Collection\Entity\Champ('Label date', $type_artefact_test, 'date');
		$champ_date->__set('description', 'Description du champ date');
		
		$champ_fichier = new Collection\Entity\Champ('Label fichier', $type_artefact_test, 'fichier');
		$champ_fichier->__set('description', 'Description du champ fichier');
		
		$champ_url = new Collection\Entity\Champ('Label url', $type_artefact_test, 'url');
		$champ_url->__set('description', 'Description du champ url');
		
		$manager->persist($type_artefact_test);
		$manager->persist($champ_texte);
		$manager->persist($champ_textarea);
		$manager->persist($champ_nombre);
		$manager->persist($champ_date);
		$manager->persist($champ_fichier);
		$manager->persist($champ_url);
		
		$manager->flush();
		
		/* ***************************** *
		 * QUELQUES INSANCES D'ARTEFACTS *
		* ****************************** */
		
		$description = "
			<p><b>Pellentesque habitant morbi tristique</b> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <i>Aenean ultricies mi vitae est.</i> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href='#'>Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>
			<h2>Header Level 2</h2>
			<ol>
			   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
			   <li>Aliquam tincidunt mauris eu risus.</li>
			</ol>
			<blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote>
			<h3>Header Level 3</h3>
			<ul>
			   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
			   <li>Aliquam tincidunt mauris eu risus.</li>
			</ul>";
		
		/*
		 * Un matériel
		 */
		/*$materiel = new Collection\Entity\Artefact('Exemple de matériel', $type_artefact_materiel);
		$materiel->datas = new \Doctrine\Common\Collections\ArrayCollection();
		$materiel->description = $description;
		
		$champ_fabriquant = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fabriquant', 'type_element'=>$type_artefact_materiel));
		$data_fabriquant = new Collection\Entity\Data($materiel, $champ_fabriquant);
		$data_fabriquant->__set('texte', 'Inconnu');
		$materiel->datas->add($data_fabriquant);
		
		$champ_debut = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Début de période', 'type_element'=>$type_artefact_materiel));
		$data_debut = new Collection\Entity\Data($materiel, $champ_debut);
		$data_debut->__set('date', new DateTime('1925-01-01'));
		$materiel->datas->add($data_debut);

		$champ_fin = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fin de période', 'type_element'=>$type_artefact_materiel));
		$data_fin = new Collection\Entity\Data($materiel, $champ_fin);
		$data_fin->__set('date', new DateTime('1950-01-01'));
		$materiel->datas->add($data_fin);

		$manager->persist($materiel);
		$manager->flush();*/

		/*
		 * Une personne
		 */
		/*$personne = new Collection\Entity\Artefact('Exemple de personne', $type_artefact_personne);
		$personne->datas = new \Doctrine\Common\Collections\ArrayCollection();
		$personne->description = $description;
		
		$champ_nationnalite = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Nationnalité', 'type_element'=>$type_artefact_personne));
		$data_nationnalite = new Collection\Entity\Data($personne, $champ_nationnalite);
		$data_nationnalite->__set('texte', 'Français');
		$personne->datas->add($data_nationnalite);
		
		$champ_naissance = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date de naissance', 'type_element'=>$type_artefact_personne));
		$data_naissance = new Collection\Entity\Data($personne, $champ_naissance);
		$data_naissance->__set('date', new DateTime('1709-02-24'));
		$personne->datas->add($data_naissance);
		
		$champ_deces = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date de décès', 'type_element'=>$type_artefact_personne));
		$data_deces = new Collection\Entity\Data($personne, $champ_deces);
		$data_deces->__set('date', new DateTime('1782-11-21'));
		$personne->datas->add($data_deces);
		
		$manager->persist($personne);
		$manager->flush();*/
		
		/*
		 * Un logiciel
		*/
		/*$logiciel = new Collection\Entity\Artefact('Exemple de logiciel', $type_artefact_logiciel);
		$logiciel->datas = new \Doctrine\Common\Collections\ArrayCollection();
		$logiciel->description = $description;
		
		$champ_editeur = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Editeur', 'type_element'=>$type_artefact_logiciel));
		$data_editeur = new Collection\Entity\Data($logiciel, $champ_editeur);
		$data_editeur->__set('texte', 'Microsoft');
		$logiciel->datas->add($data_editeur);
		
		$champ_auteurs = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Auteur(s)', 'type_element'=>$type_artefact_logiciel));
		$data_auteurs = new Collection\Entity\Data($logiciel, $champ_auteurs);
		$data_auteurs->__set('texte', 'Inconnu');
		$logiciel->datas->add($data_auteurs);
		
		$champ_langage = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Langages', 'type_element'=>$type_artefact_logiciel));
		$data_langage = new Collection\Entity\Data($logiciel, $champ_langage);
		$data_langage->__set('texte', 'Java, C');
		$logiciel->datas->add($data_langage);
		
		$champ_debut = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Début de période', 'type_element'=>$type_artefact_logiciel));
		$data_debut = new Collection\Entity\Data($logiciel, $champ_debut);
		$data_debut->__set('date', new DateTime('2007-01-01'));
		$logiciel->datas->add($data_debut);
		
		$champ_fin = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fin de période', 'type_element'=>$type_artefact_logiciel));
		$data_fin = new Collection\Entity\Data($logiciel, $champ_fin);
		$data_fin->__set('date', new DateTime('2012-01-01'));
		$logiciel->datas->add($data_fin);
		
		$manager->persist($logiciel);
		$manager->flush();*/
		
		/*
		 * Un document
		 */
		/*$document = new Collection\Entity\Artefact('Exemple de document', $type_artefact_document);
		$document->datas = new \Doctrine\Common\Collections\ArrayCollection();
		$document->description = $description;
		
		$champ_editeur = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Editeur', 'type_element'=>$type_artefact_document));
		$data_editeur = new Collection\Entity\Data($document, $champ_editeur);
		$data_editeur->__set('texte', 'Hachette');
		$document->datas->add($data_editeur);
		
		$champ_auteurs = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Auteur(s)', 'type_element'=>$type_artefact_document));
		$data_auteurs = new Collection\Entity\Data($document, $champ_auteurs);
		$data_auteurs->__set('texte', 'Inconnu');
		$document->datas->add($data_auteurs);
		
		$champ_debut = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date', 'type_element'=>$type_artefact_document));
		$data_date = new Collection\Entity\Data($document, $champ_debut);
		$data_date->__set('date', new DateTime('2011-05-09'));
		$document->datas->add($data_date);
		
		$manager->persist($document);
		$manager->flush();*/
		
		/*
		 * Une institution
		*/
	/*	$institution = new Collection\Entity\Artefact('Exemple d\'institution', $type_artefact_institution);
		$institution->datas = new \Doctrine\Common\Collections\ArrayCollection();
		$institution->description = $description;
		
		$champ_debut = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Création', 'type_element'=>$type_artefact_institution));
		$data_debut = new Collection\Entity\Data($institution, $champ_debut);
		$data_debut->__set('date', new DateTime('2008-05-09'));
		$institution->datas->add($data_debut);
		
		$champ_fin = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fin', 'type_element'=>$type_artefact_institution));
		$data_fin = new Collection\Entity\Data($institution, $champ_fin);
		$data_fin->__set('date', new DateTime('2011-12-04'));
		$institution->datas->add($data_fin);
		
		$champ_adresse = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Adresse(s)', 'type_element'=>$type_artefact_institution));
		$data_adresse = new Collection\Entity\Data($institution, $champ_adresse);
		$data_adresse->__set('texte', '40 rue de Peupliers 38000 Grenoble');
		$institution->datas->add($data_adresse);
		
		$manager->persist($institution);
		$manager->flush();*/
		
		/*
		 * Un lieu
		*/
		/*$lieu = new Collection\Entity\Artefact('Exemple de lieu', $type_artefact_lieu);
		$lieu->datas = new \Doctrine\Common\Collections\ArrayCollection();
		$lieu->description = $description;
		
		$champ_adresse = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Adresse', 'type_element'=>$type_artefact_lieu));
		$data_adresse = new Collection\Entity\Data($lieu, $champ_adresse);
		$data_adresse->__set('texte', '40 rue de Peupliers 38000 Grenoble');
		$lieu->datas->add($data_adresse);
		
		$manager->persist($lieu);
		$manager->flush();*/

		
		/* ********************************** *
		 * DES RELATIONS ENTRE DEUX ARTEFACTS *
		* *********************************** */
		
		/*$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_materiel);
		$semantique->__set('semantique', 'A inventé');
		$manager->persist($semantique);
		$manager->flush();
		
		$relation = new Collection\Entity\RelationArtefacts();
		$relation->__set('origine', $vauc);
		$relation->__set('destination', $calc);
		$relation->__set('semantique', $semantique);
		$manager->persist($relation);
		
		$semantique2 = new Collection\Entity\SemantiqueArtefact();
		$semantique2->__set('type_origine', $type_artefact_personne);
		$semantique2->__set('type_destination', $type_artefact_logiciel);
		$semantique2->__set('semantique', 'Est l\'auteur de');
		$manager->persist($semantique2);
		$manager->flush();
		
		$relation2 = new Collection\Entity\RelationArtefacts();
		$relation2->__set('origine', $vauc);
		$relation2->__set('destination', $logiciel);
		$relation2->__set('semantique', $semantique2);
		$manager->persist($relation2);

		
		$manager->flush();*/
	}
}
