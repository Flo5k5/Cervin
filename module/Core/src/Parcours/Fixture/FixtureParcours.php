<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class FixtureParcours implements FixtureInterface
{
	
	public function load(ObjectManager $manager)
	{
		
		/*
		 * Quelques artefacts et sémantiques pour remplir les scènes
		 */
		
		$type_artefact_personne = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Personne'));
		$jean_kuntzmann = new Collection\Entity\Artefact(null, $type_artefact_personne);
		$jean_kuntzmann->populate(null);
		$jean_kuntzmann->titre = 'Jean Kutzmann';
		$jean_kuntzmann->description = "
				<br>
				Jean Kuntzmann (1912-1992) fut un mathématicien français qui joua un rôle décisif dans le développement de l'informatique et des mathématiques appliquées dans la recherche et l'enseignement supérieur en France.
				<br>
				<br>
				Après des études de mathématiques à l'École Normale Supérieure, Kuntzmann soutient en 1940 une thèse de doctorat en algèbre. Prisonnier de guerre, il est en captivité jusqu'en 1945, date à laquelle il rejoint Grenoble où il avait été nommé professeur en 1942. Dès son arrivée, il crée un enseignement de mathématiques pour l'ingénieur, initiative novatrice pour l'époque. Il établit une collaboration avec des entreprises industrielles de la région (Neyrpic, Merlin Gerin), qui ont de gros besoins de calcul numérique. Il perçoit très vite le potentiel du calcul automatique et créée en 1951 un Laboratoire de Calcul, auquel les contrats industriels apporteront des ressources substantielles.
				<br>
				<br>
				Initialement équipé de machines mécaniques, ce laboratoire acquiert en 1952 un calculateur analogique OME 12 de la SEA et développe ses collaborations (ministère de l'Air, EDF, CNET). Ne possédant pas d'ordinateur, le Laboratoire utilise en 1955-56 des machines extérieures : le Gamma 3 de la société Normacem à Lyon, puis l'IBM 650 de Neyrpic-Sogreah à Grenoble.
				<br>
				<br>
				Les premiers enseignements de programmation sont mis en place à cette occasion en 1956, d'abord de manière informelle, puis avec la création d'une section \"mathématiques appliquées\" à l'Institut Polytechnique de Grenoble (IPG). Cette initiative préfigure la création en 1960, au sein de l'IPG, d'une École d'ingénieurs en informatique et mathématiques appliquées, qui deviendra l'ENSIMAG, et dont Kuntzmann sera le premier directeur.
				<br>
				<br>
				En 1957, Kuntzmann créée l'AFCAL, Association Française de Calcul (qui deviendra plus tard l'AFCALTI, puis l'AFCET) et, en 1958, la revue \"<i>Chiffres</i>\". En 1957 également, le Laboratoire de Calcul obtient une dotation pour l'achat d'un ordinateur. Sera choisi le Bull Gamma ET, inauguré en janvier 1958. L'arrivée de cet ordinateur marque le début d'une activité de recherche en informatique, qui se concrétisera au début des années 1960 par la soutenance de nombreuses thèses dans ce domaine. Les thèmes de recherche initiaux sont les langages de programmation et la compilation, ainsi que l'architecture des ordinateurs. Le Laboratoire de calcul, devenu Institut de Mathématiques Appliquées de Grenoble (IMAG), élargira plus tard le spectre de ses activités et deviendra en 1966 l'un des premiers laboratoires associés au CNRS (LA n° 7).
				<br>
				<br>
				Kuntzmann gardera la direction de l'IMAG, devenu l'un des tout premiers centres de recherche en informatique en France,  jusqu'à sa retraite en 1977. Dans les années 1970, il avait créé une équipe de recherche sur la didactique des mathématiques, sujet sur lequel il continuera à travailler, publiant plusieurs ouvrages.
				<br>
				<br>
				En 2007, le nom de Jean Kuntzmann est donné à l'un des laboratoires créés à la suite de la dissolution de la fédération IMAG. Le 14 décembre 2012, une journée de commémoration a été organisée à Grenoble pour le centenaire de sa naissance.
				<br>
		";
		$manager->persist($jean_kuntzmann);
		
		$type_artefact_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$gamma_3 = new Collection\Entity\Artefact(null, $type_artefact_materiel);
		$gamma_3->populate(null);
		$gamma_3->titre = 'Gamma 3';
		$gamma_3->description = "
				<br>
				Le calculateur Bull Gamma 3A symbolise la transition entre mécanographie et informatique. Cette machine est composée d’une tabulatrice dont l’organe de calcul est un calculateur électronique, qui est donc “esclave” de la tabulatrice. Ce calculateur est programmable au moyen d’un tableau de connexion, ce qui lui permet d’enchaîner plusieurs opérations en vue de calculs complexes.
				<br>
				<br>
				Cette machine, produite en 1 200 exemplaires à partir de 1952-53, connut un grand succès pour les applications de gestion dans l’industrie, les banques et les assurances, car elle permettait de réutiliser le matériel mécanographique existant. Une version Gamma 3M, munie d’un opérateur en virgule flottante, fut introduite pour le calcul scientifique. Le successeur du Gamma 3, le Bull Gamma ET (“Extension Tambour”), livré à partir de 1957, était muni d’une mémoire à tambour magnétique contenant le programme et les données. Dans le Gamma ET, les rôles de la tabulatrice et du calculateur étaient inversés : l’organe maître était le calculateur, la tabulatrice servant de périphérique d’entrée-sortie. La transition entre mécanographie et informatique était accomplie.
				<br>
		";
		$manager->persist($gamma_3);
		
		$type_artefact_personne = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Personne'));
		$rene_perret = new Collection\Entity\Artefact(null, $type_artefact_personne);
		$rene_perret->populate(null);
		$rene_perret->titre = 'René Perret';
		$rene_perret->description = "
				<br>
				René Perret (1924-2003) a été l’un des pionniers de l'enseignement et de la recherche universitaire en automatique en France. En 1957, il a fondé le Laboratoire de Servomécanismes qui deviendra le Laboratoire d'Automatique de Grenoble (LAG), puis le Gipsa-Lab. Il a été le directeur de ce laboratoire de 1957 à 1982, puis directeur honoraire de 1983 à 1994. Il a été à l'origine du premier calculateur industriel issu d'une université française (MAT 01) ; un des premiers calculateurs au monde utilisant la technologie des circuits intégrés. Ce calculateur, construit par la société Mors, était la version industrielle d'un calculateur conçu par deux thésards du LAG dirigés par R. Perret. Ce calculateur a permis au LAG d'entreprendre des recherches sur les méthodes de contrôle/commande de procédés par calculateur et à la société Mors de réaliser les premières installations industrielles de contrôle/commande.
				<br>
		";
		$manager->persist($rene_perret);
		
		$type_artefact_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$MAT_01 = new Collection\Entity\Artefact(null, $type_artefact_materiel);
		$MAT_01->populate(null);
		$MAT_01->titre = 'Calculateur MAT 01';
		$manager->persist($MAT_01);
		
		$type_artefact_document = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Document'));
		$cours = new Collection\Entity\Artefact(null, $type_artefact_document);
		$cours->populate(null);
		$cours->titre = 'Cours "Calculateurs Electroniques" de René Perret';
		$cours->description = "
				<br>
				En 1961-62, René Perret inaugure un cours sur les calculateurs électroniques, en 3-ème année de l'EIEG (École d'Ingénieurs Électroniciens de Grenoble). C'est l'un des tout premiers enseignements délivrés en France sur ce sujet. Il est notamment alimenté par les recherches menées au LAG (Laboratoire d'Automatique de Grenoble).
				<br>
				<br>
				L'EIEG, créée par Jean Benoît, devait devenir l'ENSERG (École Nationale Supérieure d'Électronique et de Radioélectricité de Grenoble, appartenant à l'Institut National Polytechnique de Grenoble).
				<br>
		";
		$manager->persist($cours);
		
		$semantique_chronologie = new Parcours\Entity\SemantiqueTransition();
		$semantique_chronologie->semantique = "Chronologique";
		$semantique_chronologie->description = "La scène destination suit chronologiquement la scène origine.";
		$manager->persist($semantique_chronologie);

		$semantique_logique = new Parcours\Entity\SemantiqueTransition();
		$semantique_logique->semantique = "Logique";
		$semantique_logique->description = "La scène destination suit la scène origine dans un raisonnement, une explication, une démonstration.";
		$manager->persist($semantique_logique);
		
		$semantique_analogie = new Parcours\Entity\SemantiqueTransition();
		$semantique_analogie->semantique = "Analogie";
		$semantique_analogie->description = "La scène destination est une transposition de la scène origine à un autre domaine";
		$manager->persist($semantique_analogie);
		
		$semantique_illustration = new Parcours\Entity\SemantiqueTransition();
		$semantique_illustration->semantique = "Illustration";
		$semantique_illustration->description = "Le scène destination illustre plus concrètement la scène origine, plus abstraite.";
		$manager->persist($semantique_illustration);
		
		$semantique_digression = new Parcours\Entity\SemantiqueTransition();
		$semantique_digression->semantique = "Digression";
		$semantique_digression->description = "La scène destination élargit le discours autour de la scène origine, sans y être indispensable.";
		$manager->persist($semantique_digression);
		
		$semantique_precision = new Parcours\Entity\SemantiqueTransition();
		$semantique_precision->semantique = "Précision";
		$semantique_precision->description = "La scène destination apporte une information complémentaire précise sur une partie de la scène origine, sans être indispensable à la compréhension de celle-ci.";
		$manager->persist($semantique_precision);
		
		$semantique_experience = new Parcours\Entity\SemantiqueTransition();
		$semantique_experience->semantique = "Expérience";
		$semantique_experience->description = "La scène destination propose au visiteur de \"faire l'expérience\" d'une notion présentée dans la scène origine.";
		$manager->persist($semantique_experience);
		
		$semantique_prolepse = new Parcours\Entity\SemantiqueTransition();
		$semantique_prolepse->semantique = "Prolepse";
		$semantique_prolepse->description = "La scène destination est une scène qui apparaît plus tard dans le chemin recommandé (il s'agit donc d'un avant goût).";
		$manager->persist($semantique_prolepse);
		
		$semantique_analepse = new Parcours\Entity\SemantiqueTransition();
		$semantique_analepse->semantique = "Analepse";
		$semantique_analepse->description = "La scène destination est une scène qui apparaît plus tôt dans le chemin recommandé (il s'agit donc d'un rappel).";
		$manager->persist($semantique_analepse);
		
		$semantique_enallage = new Parcours\Entity\SemantiqueTransition();
		$semantique_enallage->semantique = "Enallage";
		$semantique_enallage->description = "La scène destination introduit une rupture (de sujet, de ton, de rythme) par rapport à la scène origine.";
		$manager->persist($semantique_enallage);
		
		$semantique_secret = new Parcours\Entity\SemantiqueTransition();
		$semantique_secret->semantique = "Passage secret";
		$semantique_secret->description = "La scène destination appartient à un autre parcours que la scène origine, la transition est proposée.";
		$manager->persist($semantique_secret);
		
		$manager->flush();
		
		/*
		 * Parcours, Sous-parcours
		 */
		$parcours = new Parcours\Entity\Parcours();
		$parcours->titre = "L'histoire de l'informatique à Grenoble";
		$parcours->description = "Grenoble est l'un des principaux centres d'activité informatique en France, caractérisé par une synergie entre formation, recherche et industrie. Ce parcours retrace les principales étapes du développement de l'informatique à Grenoble et dans sa région.";
		$parcours->sous_parcours = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_debut = new Parcours\Entity\SousParcours();
		$sous_parcours_debut->titre = "Les débuts (1950-1965)";
		$sous_parcours_debut->description = "Dans les années 1950, la France souffre d'un important retard en informatique. Néanmoins, grâce à leur clairvoyance et à leur ténacité, quelques précurseurs sauront créer les formations, les infrastructures de recherche et les collaborations industrielles qui permettront le développement de cette nouvelle discipline et de ses applications.";
		$sous_parcours_debut->scenes = new \Doctrine\Common\Collections\ArrayCollection();
		$sous_parcours_debut->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		
		$parcours->addSousParcours($sous_parcours_debut);
		
		$manager->persist($parcours);
		$manager->flush();
		
		/*
		 * Première scène
		 */
		$scene1 = new Parcours\Entity\SceneRecommandee();
		$scene1->titre = "Tout commence par le calcul";
		$scene1->narration = "
				<br>
				L'histoire de l'informatique à Grenoble commence avec l'arrivée du professeur Jean Kuntzmann en 1945. Sollicité par Félix Esclangon, directeur de l'Institut Polytechnique de Grenoble (École d'ingénieurs rattachée à l'université), il met en place un enseignement de mathématiques à l'usage des ingénieurs. Sensibilisé aux besoins en calcul numérique par ses contacts industriels (Neyrpic, Merlin Gerin), il crée en 1951 un Laboratoire de calcul qui tirera une grande partie de ses ressources de contrats avec l'industrie (son intitulé précise : \"Laboratoire d'essai ouvert aux applications industrielles\"). Ce laboratoire est implanté dans les combles de l'Institut Polytechnique, avenue Félix Viallet, au centre de Grenoble.
				<br>
				<br>
				Initialement équipé de calculatrices mécaniques et électromécaniques, le Laboratoire de calcul acquiert en 1952 un calculateur analogique, l'OME 12 de la SEA (Société d'Électronique appliquée à l'Automatisme), grâce à ses contacts avec le ministère de l'Air.
				<br>
				<br>
				À partir de 1956, le Laboratoire de calcul, qui a recruté un ingénieur, Louis Bolliet, se tourne vers l'informatique, en utilisant initialement les ordinateurs de ses partenaires industriels (Gamma 3 de Normacem à Lyon, puis IBM 650 de la Sogreah à Grenoble). En 1957, le Laboratoire obtient une dotation pour l'achat d'un ordinateur : ce sera le Bull Gamma ET (extension tambour).
				<br>
				<br>
				Parallèlement, les automaticiens, sous la conduite du professeur René Perret, développent une activité, également soutenue par des contacts industriels, qui conduira à la construction des premiers ordinateurs de commande de procédés. Mais la collaboration entre informatique et automatique ne s'établira pas, malgré un intérêt mutuel et des contacts suivis en 1959-1960. Cette scission initiale marquera durablement le paysage scientifique et industriel grenoblois.
				<br>
				<br>
				Au début des années 1960, le Laboratoire de calcul entame une activité de recherche en informatique. Les premiers doctorants sont issus des premières promotions de la nouvelle école d'ingénieurs créée par Kuntzmann, et qui deviendra l'ENSIMAG.
				<br>
				<br>
				Les années 1963-64 marquent une étape importante : premières thèses d'informatique, installation sur le nouveau campus (dont l'informatique sera le premier occupant), acquisition d'un puissant ordinateur, l'IBM 7044. Le Laboratoire de calcul devient un institut de recherche, l'IMAG (Institut de Mathématiques Appliquées de Grenoble), qui sera en 1966 l'un des premiers laboratoires associés au CNRS. L'exploitation des ressources informatiques est dévolue à un prestataire de services, le centre de calcul, futur CICG (Centre interuniversitaire de calcul de Grenoble). Cette organisation restera en place jusqu'aux années 1980.
				<br>
		";
		$scene1->elements = new \Doctrine\Common\Collections\ArrayCollection();
		$scene1->elements->add($jean_kuntzmann);
		$scene1->elements->add($gamma_3);
		
		$sous_parcours_debut->addScene($scene1);
		$sous_parcours_debut->scene_depart = $scene1;
		$manager->flush();
		
		/*
		 * Deuxième scène
		*/
		$scene2 = new Parcours\Entity\SceneRecommandee();
		$scene2->titre = "L'automatique, moteur de l'industrie";
		$scene2->narration = "
				<br>
				En 1957, René Perret, qui vient de soutenir une thèse à l'université de Grenoble et revient d'un séjour aux États-Unis, crée un Laboratoire de Servomécanismes, rattaché à la faculté des sciences et à l'Institut polytechnique, qui deviendra en 1961 le Laboratoire d'Automatique de Grenoble (LAG). Devenu rapidement professeur, il établit dès le départ de nombreux contacts avec le monde industriel. Les contacts avec le Laboratoire de calcul (futur IMAG) de Jean Kuntzmann, créé quelques années auparavant et dans un esprit analogue, n'aboutiront pas à une collaboration, et les deux laboratoires évolueront indépendamment.
				<br>
				<br>
				À partir de 1960, le laboratoire s'intéresse à l'utilisation des circuits à transistors pour la logique booléenne. En 1961, ces travaux trouvent une application chez la société Mors, constructeur d'automatismes à relais, pour remplacer les relais électromagnétiques par des relais statiques. En 1962, un département \"automatisme et électronique\" est créé au sein de la société Mors, dans les locaux de l'IPG, sous l'impulsion de Guy Jardin, ingénieur venu suivre une formation dans la section spéciale \"automatique\" de l'IPG, et de Michel Deguerry, qui quitte le LAG pour une carrière industrielle.
				<br>
				<br>
				Son activité étant en forte croissance, ce département s'installe dans de nouveaux locaux, tout en renforçant sa collaboration avec le LAG. Les clients viennent de nombreux secteurs d'activité : pétrole, chimie, marine, énergie atomique, houillères et sidérurgie. La société conçoit une gamme de produits, dont un calculateur industriel, le MAT 01 (photo ci-contre), issu d'un travail de thèse au LAG, qui sera construit à une vingtaine d'exemplaires. C'est l'un des premiers calculateurs industriels au monde utilisant des circuits intégrés.
				<br>
				<br>
				Est alors créée au sein de Mors, en 1965, une division \"automatismes, transmission, matériel\" (ATM) qui s'installera dans une nouvelle usine à Crolles, près de Grenoble.
				<br>
				<br>
				Le cas de Mors dans les années 1960 est un exemple de collaboration fructueuse entre recherche et industrie. De nombreuses recherches du LAG sont effectuées en coopération avec Mors et une partie des thèses est réalisée sur des sites industriels. Des actions concertées tripartites associent le LAG, Mors et un client \"automatisé\", comme Naphtachimie.
				<br>
		";
		$scene2->elements = new \Doctrine\Common\Collections\ArrayCollection();
		$scene2->elements->add($rene_perret);
		$scene2->elements->add($MAT_01);
		
		$sous_parcours_debut->addScene($scene2);
		$manager->flush();
		
		/*
		 * Transition scene1->scene2
		 */
		
		$transition1 = new Parcours\Entity\TransitionRecommandee();
		$transition1->narration = "Vers l'automatique.";
		$transition1->semantique = $semantique_chronologie;
		$transition1->scene_origine = $scene1;
		$transition1->scene_destination = $scene2;
		
		$sous_parcours_debut->addTransition($transition1);
		$manager->flush();
		
		/*
		 * Troisième scène
		*/
		$scene3 = new Parcours\Entity\SceneRecommandee();
		$scene3->titre = "Inventer la formation";
		$scene3->narration = "
				<br>
				Dans les années 1950, pour la formation à la discipline naissante de l'informatique, tout est à inventer, à commencer par la formation des formateurs. À Grenoble, les cours de mathématiques appliquées de Jean Kuntzmann sont complétés par des travaux pratiques, initialement effectués à l'aide de calculatrices de bureau, sous la direction de Jean Laborde. À partir de 1952, un calculateur analogique SEA OME 12 permet de traiter l'intégration d'équations différentielles et d'équations aux dérivées partielles. Mais la transition vers l'informatique reste à accomplir.
				<br>
				<br>
				Le Laboratoire de calcul n'avait pas initialement d'ordinateur et utilisait ceux de ses partenaires industriels. C'est ainsi que le premier cours de programmation fut donné en 1956 par M. Sollaud, ingénieur à la société Normacem de Lyon, sur le calculateur  Bull Gamma 3 muni d'une extension permettant d'introduire un programme sur cartes, au lieu d'utiliser le tableau de connexion. Les cours avaient lieu à Lyon le samedi matin. Louis Bolliet rappelle qu'il y avait 4 auditeurs : Jean Kuntzmann, Jean Laborde, Henri Rohrbach (élève ingénieur à l'IPG) et lui-même. L'année suivante, Sogreah s'équipa d'un IBM 650 et des cours de programmation eurent encore lieu sur cette machine.
				<br>
				<br>
				Enfin, à partir de 1958, le Laboratoire de calcul possède son propre ordinateur, un Bull Gamma ET, qui sert aussi de support à l'enseignement de la programmation. Outre le code machine, les premiers langages utilisés sont Fortran et Cobol, Algol ne devant apparaître qu'un peu plus tard. Ci-contre (collection Aconit), des cartes utilisées pour le premier cours de programmation donné dès 1956-57 par Louis Bolliet sur Bull Gamma 3 et Gamma ET (cliquer sur l'image pour plus de détails).
				<br>
				<br>
				Parmi les autres cours marquants, il faut citer :
				<ol>
			   		<li> le cours \"Calculateurs électroniques\" donné par René Perret à partir de 1961-62 à l'EIEG (École des Ingénieurs Électroniciens de Grenoble, école de l'institut Polytechnique de Grenoble, ou IPG) ; </li>
    				<li> le cours \"Logique et programmation\" donné par Bernard Vauquois à partir de 1959. </li>
				</ol>
				<br>
				<br>
				Jean Kuntzmann crée en 1956 une section spéciale \"Mathématiques Appliquées\" à l'institut Polytechnique de Grenoble. La première année, cette section n'a qu'un élève, Henri Rohrbach, qui obtient son diplôme avec la promotion suivante (5 étudiants) ; puis la croissance s'accélère. En 1960 est créée une section \"normale\" de Mathématiques appliquées, constituant une École d'ingénieurs à part entière, qui deviendra l'ENSIMAG. La première promotion, sortie en 1963, compte 13 élèves (photo ci-contre).
				<br>
				<br>
				La section spéciale de Mathématiques appliquées (qui accueille des ingénieurs déjà diplômés dans un autre domaine), bientôt étendue à l'informatique,  continuera de fonctionner jusqu'en 2012.
				<br>
				<br>
				La formation continue avait démarré dès 1951 avec la Promotion Supérieure du Travail (PST). À partir de 1959, elle s'étend au calcul numérique, puis à l'informatique et devient un institut rattaché à l'université. Plus tard, celui-ci sera associé au Conservatoire National des Arts et Métiers (CNAM) et formera des ingénieurs en informatique.
				<br>
				<br>
				Au début des années 1960 sont créées de nouvelles formations.
				<ol>
			   		<li> DEST (diplôme d'études supérieures techniques) de programmation, </li>
    				<li> licence de sciences appliquées comprenant un certificat de Techniques de la programmation, </li>
    				<li> 3ème cycle de mathématiques appliquées et d'informatique. </li>
				</ol>
				Les enseignants, souvent issus de ces mêmes filières, ont alors peu d'avance sur leurs étudiants.
				<br>
		";
		$scene3->elements = new \Doctrine\Common\Collections\ArrayCollection();
		$scene3->elements->add($cours);
		
		$sous_parcours_debut->addScene($scene3);
		$manager->flush();
		
		/*
		 * Transition scene2->scene3
		*/		
		$transition2 = new Parcours\Entity\TransitionRecommandee();
		$transition2->narration = "Vers la formation";
		$transition2->semantique = $semantique_chronologie;
		$transition2->scene_origine = $scene2;
		$transition2->scene_destination = $scene3;
		
		$sous_parcours_debut->addTransition($transition2);
		$manager->flush();
		
		/*
		 * Quatrième scène
		*/
		$scene4 = new Parcours\Entity\SceneRecommandee();
		$scene4->titre = "Les débuts de la recherche en informatique";
		$scene4->narration = "
				<br>
				La recherche commence dès la création du Laboratoire de calcul. En effet, les nombreuses applications traitées par le laboratoire nécessitent de perfectionner les méthodes et les outils de ce qui deviendra plus tard l'analyse numérique. Les avancées réalisées font l'objet, en 1955, des Journées alpines de calcul numérique, organisées par le Laboratoire de calcul, IBM et la Sogreah.
				<br>
				<br>
				En 1956 commence l'activité proprement informatique, avec l'arrivée de Louis Bolliet, initialement ingénieur au Laboratoire de calcul. En 1957, Jean Kuntzmann crée l'AFCAL (Association Française de Calcul), qui deviendra plus tard l'AFCALTI, puis l'AFCET. En 1958, il crée la revue Chiffres, dont il sera le premier rédacteur en chef. Cette association et cette revue seront les premiers lieux d'échange d'information en France sur les domaines émergents de l'analyse numérique et de la programmation des ordinateurs. Le premier congrès de l'AFCAL, qui réunit 270 participants, se tiendra à Grenoble en 1960. Il attire divers spécialistes étrangers, dont Friedrich L. Bauer et  Maurice Wilkes.
				<br>
				<br>
				En 1957, arrive Noël Gastinel, mathématicien qui va diriger l'équipe de recherche en analyse numérique. S'intéressant de près aux techniques de l'informatique, il sera également plus tard le premier directeur du centre de calcul. En 1958 arrive Bernard Vauquois, qui s'est orienté vers l'informatique après un début de carrière dans l'astronomie. Il lance une activité autour de la traduction automatique, qui aboutira en 1959 à la création du CETA (Centre d'Études pour la Traduction Automatique) par le CNRS et la DRME (Direction des Recherches et Moyens d'Essai du ministère des Armées). Vauquois fait par ailleurs partie du comité scientifique qui définit le langage Algol 60 entre 1958 et 1961.				
				<br>
				<br>
				En 1961 démarrent des recherches dans deux domaines de l'informatique : l'algèbre de Boole, avec Kuntzmann, et la compilation des langages de programmation, avec Bolliet. Les premières thèses sont lancées, les doctorants venant des formations locales, et notamment de la section spéciale \"mathématiques appliquées\" de l'IPG. Suivant la pratique inaugurée par le Laboratoire de calcul, ces recherches font l'objet de nombreuses collaborations avec l'industrie.
				<br>
				<br>
				Les années 1963-64 voient l'installation du laboratoire (devenu IMAG, Institut de Mathématiques Appliquées de Grenoble) sur le campus créé à Saint-Martin d'Hères et Gières, l'acquisition d'un ordinateur puissant, l'IBM 7044, et l'aboutissement des premières thèses en informatique :
				<ol>
				    <li>Jean-Loup Baer, thèse de 3-ème cycle : \"Principes de compilation de COBOL\", 1963.</li>
				    <li>Jean Le Palmec, thèse de docteur-ingénieur : Étude d'un langage intermédiaire pour la compilation d'Algol 60, 1964</li>
				    <li>Jean-Claude Boussard, thèse d'État : Étude et réalisation d'un compilateur Algol 60 pour ordinateur 7040-44, 1964.</li>
				<br>
				<br>
				À noter que cette thèse d'État est en \"sciences appliquées\", la discipline Informatique n'étant pas encore officiellement reconnue (il faudra attendre 1969). Au total, cinq thèses de \"sciences appliquées\" seront soutenues dont, en 1967, celle de Louis Bolliet qui prendra alors un poste de professeur.
				<br>
				<br>
				Deux colloques, tenus en 1965, sur l'enseignement de la programmation et sur l'algèbre de Boole, témoignent de la vitalité scientifique du laboratoire. Le groupe Algol WG2.1 de l'IFIP (<i>International Federation for Information Processing</i>) tient cette même année une réunion de travail à Saint-Pierre de Chartreuse. Algol 60 est alors à l'IMAG un thème de travail et un outil privilégié (en témoigne le livre de L. Bolliet, N. Gastinel et P.-J. Laurent, <i>Un nouveau langage scientifique : Algol</i>, Hermann 1964).
				<br>
				<br>
				La recherche en informatique est maintenant lancée; elle va connaître un grand développement et une extension de son domaine dans les années qui suivent.
				<br>
		";
		$scene4->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_debut->addScene($scene4);
		$manager->flush();
		
		/*
		 * Transition scene3->scene4
		*/
		$transition3 = new Parcours\Entity\TransitionRecommandee();
		$transition3->narration = "Vers les débuts de la recherche en informatique";
		$transition3->semantique = $semantique_chronologie;
		$transition3->scene_origine = $scene3;
		$transition3->scene_destination = $scene4;
		
		$sous_parcours_debut->addTransition($transition3);
		$manager->flush();
		
		/*
		 * Cinquième scène
		*/
		$scene5 = new Parcours\Entity\SceneRecommandee();
		$scene5->titre = "Technologie et composants";
		$scene5->narration = "
				<br>
				L'industrie électronique à Grenoble connaît un démarrage lent dans les années 1950. Nous replaçons ici ses débuts dans le contexte plus large de l'histoire des composants électroniques modernes.
				<br>
				<blockquote><br>
				Cette histoire commence avec l'invention du transistor en 1947. Ce dispositif semi-conducteur va rapidement remplacer les tubes électroniques, avec une fiabilité bien plus élevée, un faible encombrement et une consommation d'énergie réduite. Dès 1950, le transistor est intégré dans des produits de grande consommation. Le premier ordinateur transistorisé est construit par les Bell Labs en 1954. Dès lors, l'emploi du transistor dans les circuits des ordinateurs va se généraliser.
				<br></blockquote>
				<br>
				En 1955, la Compagnie Générale de Télégraphie sans fil (CSF) transforme son usine de Saint-Égrève (banlieue ouest de Grenoble), dédiée à la fabrication de tubes à vide, en une usine de production de transistors (ci-contre, vue d'un atelier). Après des déboires initiaux dus à un changement mal maîtrisé des méthodes de production, cette activité sera filialisée en 1960 sous le nom de COSEM (Compagnie générale des semi-conducteurs). En 1961-62, la COSEM détenait près de 45% du marché des semi-conducteurs en France et réalisait 30% de son chiffre d'affaires à l'exportation.
				<br>
				<br>
				En 1956, le Commissariat à l'Énergie Atomique (CEA) crée le Centre d'Études Nucléaires de Grenoble (CENG), également implanté à l'ouest de Grenoble. En 1957 est créé au CENG, sous la direction de Michel Cordelle, un service électronique dont la mission initiale est la conception, la réalisation et la maintenance de l'appareillage de commande et de mesure du réacteur nucléaire Mélusine.
				<br>
				<blockquote><br>
				En 1958, Jack Kilby invente le premier circuit intégré à base de germanium : les transistors ne sont plus des composants discrets (séparés), mais fondus dans la masse même du semi-conducteur. Quelques mois plus tard, en 1959, Robert Noyce invente le circuit intégré à base de silicium, qui deviendra la technique dominante. En France, dans les années 1960, la plus grande partie des circuits intégrés est produite dans des usines d'entreprises américaines (Texas Instruments, Motorola, IBM).
				<br></blockquote>
				<br>
				En 1962, le CEA décide de créer sa propre technologie des transistors et circuits intégrés afin de maîtriser l'environnement électronique des réacteurs. La mission du service électronique du CENG (futur LETI) s'élargit en conséquence. En 1963 sortent les premiers transistors et au début de 1965 le premier circuit intégré, comportant 10 transistors (photo ci-contre).
				<br>
				<blockquote>
				En 1965, Gordon Moore énonce sa \"loi\" : le nombre de transistors dans les circuits intégrés doublera environ tous les 18 mois. Plus de 40 ans après, cette loi s'applique toujours, mais on en perçoit les limites.
				</blockquote>
				";
		$scene5->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_debut->addScene($scene5);
		$manager->flush();
		
		/*
		 * Transition scene4->scene5
		*/
		$transition4 = new Parcours\Entity\TransitionRecommandee();
		$transition4->narration = "Vers les technos et composants";
		$transition4->semantique = $semantique_chronologie;
		$transition4->scene_origine = $scene4;
		$transition4->scene_destination = $scene5;
		
		$sous_parcours_debut->addTransition($transition4);
		$manager->flush();
		
	}
}
