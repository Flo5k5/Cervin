<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class FixtureParcours implements FixtureInterface
{
	
	public function load(ObjectManager $manager)
	{

		/********************************
		 *	Parcour n°1
		 ********************************/
		
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
		$parcours->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_debut = $parcours->sous_parcours_depart;
		$sous_parcours_debut->titre = "Les débuts (1950-1965)";
		$sous_parcours_debut->description = "Dans les années 1950, la France souffre d'un important retard en informatique. Néanmoins, grâce à leur clairvoyance et à leur ténacité, quelques précurseurs sauront créer les formations, les infrastructures de recherche et les collaborations industrielles qui permettront le développement de cette nouvelle discipline et de ses applications.";
		$sous_parcours_debut->scenes = new \Doctrine\Common\Collections\ArrayCollection();
		$sous_parcours_debut->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement = new Parcours\Entity\SousParcours();
		$sous_parcours_developpement->titre = "Développement, perturbations (1965-1980)";
		$sous_parcours_developpement->description = "La période 1965-1980 voit se développer l'industrie informatique à Grenoble (création de Sogeti, implantation de Hewlett-Packard, naissance de la ZIRST). Mais c'est aussi une période de fortes perturbations : restructurations en série dans le domaine des mini-ordinateurs, chemin cahoteux vers la consolidation d'une industrie nationale des semi-conducteurs, fortes restrictions de crédits pour l'enseignement supérieur et la recherche, crise de croissance de l'IMAG.";
		$sous_parcours_developpement->scenes = new \Doctrine\Common\Collections\ArrayCollection();
		$sous_parcours_developpement->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		
		$parcours->addSousParcours($sous_parcours_developpement);
		
		$sous_parcours_debut->sous_parcours_suivant = $sous_parcours_developpement;
		
		$sous_parcours_changement = new Parcours\Entity\SousParcours();
		$sous_parcours_changement->titre = "Changement de visage (1980-1995)";
		$sous_parcours_changement->description = "L'arrivée de l'Internet et de l'informatique personnelle marque un changement profond dans les techniques et les usages de l'informatique, qui se décentralise et commence à se diffuser largement. Cette mutation touchera aussi bien la recherche que l'industrie. Parallèlement, l'évolution du marché et des technologies des semi-conducteurs impose un changement d'échelle : c'est au niveau européen, puis mondial, que va se construire un nouvel acteur industriel.";
		$sous_parcours_changement->scenes = new \Doctrine\Common\Collections\ArrayCollection();
		$sous_parcours_changement->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		
		$parcours->addSousParcours($sous_parcours_changement);
		
		$sous_parcours_developpement->sous_parcours_suivant = $sous_parcours_changement;
		$sous_parcours_changement->sous_parcours_suivant = null;
		
		$manager->persist($parcours);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
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
		 * Premier sous-parcours
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
		 * Premier sous-parcours
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
		 * Premier sous-parcours
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
		 * Premier sous-parcours
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
		 * Premier sous-parcours
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
				</ol>
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
		 * Premier sous-parcours
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
		 * Premier sous-parcours
		 * Cinquième scène
		*/
		$scene5 = new Parcours\Entity\SceneRecommandee();
		$scene5->titre = "Technologie et composants";
		$scene5->narration = "
				<br>
				L'industrie électronique à Grenoble connaît un démarrage lent dans les années 1950. Nous replaçons ici ses débuts dans le contexte plus large de l'histoire des composants électroniques modernes.
				<br>
				<blockquote>
				Cette histoire commence avec l'invention du transistor en 1947. Ce dispositif semi-conducteur va rapidement remplacer les tubes électroniques, avec une fiabilité bien plus élevée, un faible encombrement et une consommation d'énergie réduite. Dès 1950, le transistor est intégré dans des produits de grande consommation. Le premier ordinateur transistorisé est construit par les Bell Labs en 1954. Dès lors, l'emploi du transistor dans les circuits des ordinateurs va se généraliser.
				</blockquote>
				En 1955, la Compagnie Générale de Télégraphie sans fil (CSF) transforme son usine de Saint-Égrève (banlieue ouest de Grenoble), dédiée à la fabrication de tubes à vide, en une usine de production de transistors (ci-contre, vue d'un atelier). Après des déboires initiaux dus à un changement mal maîtrisé des méthodes de production, cette activité sera filialisée en 1960 sous le nom de COSEM (Compagnie générale des semi-conducteurs). En 1961-62, la COSEM détenait près de 45% du marché des semi-conducteurs en France et réalisait 30% de son chiffre d'affaires à l'exportation.
				<br>
				<br>
				En 1956, le Commissariat à l'Énergie Atomique (CEA) crée le Centre d'Études Nucléaires de Grenoble (CENG), également implanté à l'ouest de Grenoble. En 1957 est créé au CENG, sous la direction de Michel Cordelle, un service électronique dont la mission initiale est la conception, la réalisation et la maintenance de l'appareillage de commande et de mesure du réacteur nucléaire Mélusine.
				<br><br>
				<blockquote>
				En 1958, Jack Kilby invente le premier circuit intégré à base de germanium : les transistors ne sont plus des composants discrets (séparés), mais fondus dans la masse même du semi-conducteur. Quelques mois plus tard, en 1959, Robert Noyce invente le circuit intégré à base de silicium, qui deviendra la technique dominante. En France, dans les années 1960, la plus grande partie des circuits intégrés est produite dans des usines d'entreprises américaines (Texas Instruments, Motorola, IBM).
				</blockquote>
				En 1962, le CEA décide de créer sa propre technologie des transistors et circuits intégrés afin de maîtriser l'environnement électronique des réacteurs. La mission du service électronique du CENG (futur LETI) s'élargit en conséquence. En 1963 sortent les premiers transistors et au début de 1965 le premier circuit intégré, comportant 10 transistors (photo ci-contre).
				<br><br>
				<blockquote>
				En 1965, Gordon Moore énonce sa \"loi\" : le nombre de transistors dans les circuits intégrés doublera environ tous les 18 mois. Plus de 40 ans après, cette loi s'applique toujours, mais on en perçoit les limites.
				</blockquote>
				";
		$scene5->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_debut->addScene($scene5);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Transition scene4->scene5
		*/
		$transition4 = new Parcours\Entity\TransitionRecommandee();
		$transition4->narration = "Vers les technos et composants";
		$transition4->semantique = $semantique_chronologie;
		$transition4->scene_origine = $scene4;
		$transition4->scene_destination = $scene5;
		
		$sous_parcours_debut->addTransition($transition4);
		$manager->flush();
		
		
		//
		// Deuxième sous-parcours
		// Sixième scène
		//
		$scene6 = new Parcours\Entity\SceneRecommandee();
		$scene6->titre = "Usages de l'informatique";
		$scene6->narration = "
				La période 1965-1980 voit le début de la pénétration de l'informatique dans un nombre croissant d'activités. Mais c'est encore souvent une informatique lourde, centralisée ; l'apparition de la micro-informatique au milieu des années 1970 mettra quelques années à produire ses effets dans les usages. L'informatique s'introduit dans le domaine des télécommunications (on parle de téléinfomatique), mais dans la pratique on est encore dans l'ère pré-Internet : à la fin des années 1970, on travaille sur des réseaux point à point et on utilise le modèle rigide du vidéotex. En 1979, une étape importante est franchie avec le lancement du réseau Transpac. La grande révolution des réseaux se fera dans les années 1980.
				<br><br>
				Cette période voit aussi le développement des sociétés de service et de conseil en informatique et le début de l'informatisation de l'administration. Si l'informatique de gestion reste le domaine majeur, on doit noter l'essor de l'informatique industrielle qui trouve de multiples champs d'application.
				<br><br>
				Si l'usage de l'informatique est encore très largement une affaire de professionnels, son impact sur la société se fait déjà sentir. D'abord par l'évolution des métiers ; ensuite par la prise de conscience des menaces sur la vie privée, qui aboutira en 1978 à la loi \"informatique et libertés\". Cette même année 1978, le rapport Nora-Minc sur l'informatisation de la société sera largement diffusé et commenté.
				<br><br>
				En France, cette période est aussi celle du plan calcul, destiné à rattraper le retard en matière d'ordinateurs de moyenne puissance pour la gestion. Mais cette tentative de pilotage par l'État se soldera globalement par un échec. On en retiendra néanmoins la création de l'IRIA, devenu INRIA, aujourd'hui acteur majeur de la recherche en informatique, qui faillit d'ailleurs disparaître à la fin des années 1970.

				<h3>Comment cette période est-elle vécue à Grenoble ?</h3>
				<blockquote>
				On constate une explosion de la demande de services informatiques, qu'il s'agisse de prestations \"classiques\" en calcul scientifique ou en informatique de gestion, ou de services plus spécialisés comme l'informatique industrielle (commande de procédés, instrumentation). Face à cette demande, on trouve une offre très complète : les SSII, à l'image de SoGETI, multiplient leurs implantations ; les services \"sur mesure\" tels que les réseaux spécialisés pour l'industrie, l'analyse et la synthèse d'images, la robotique, sont fournies par de nouvelles entreprises , notamment celles implantées sur la ZIRST, qui occupent ces marchés de niches.
				<br><br>
				Dans les années 1970 arrivent les bases de données, d'abord sur les modèles hiérarchique ou réseau, à l'image de Socrate. L'accès à ces bases de données va se faire par des réseaux point à point, en mode transactionnel, ce qui signera la fin progressive de l'usage des cartes perforées et des ateliers dédiés à ce mode d'exploitation. Ces techniques accompagnent la montée de l'informatisation du tertiaire (assurances, banques, etc.). Les bases de données relationnelles apparaissent à la fin de la période.
				<br><br>
				La recherche connaît une croissance rapide, et maintient un contact étroit avec l'industrie. Les contingences politiques et économiques, et la rapidité même de la croissance, causeront néanmoins quelques perturbations.
				<br><br>
				L'explosion de la demande se répercute aussi sur la formation : de nouvelles filières sont créées pour répondre aux besoins. Beaucoup de petites entreprises qui s'équipent en matériel informatique doivent trouver les compétences pour l'exploiter ; ce \"service informatique\" se réduit souvent à une personne.
				</blockquote>
				";
		$scene6->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->scene_depart = $scene6;
		$sous_parcours_developpement->addScene($scene6);
		$manager->flush();
		
		//
		// Transition entre deux sous-parcours
		// Transition scene5->scene6
		//
		$transition5 = new Parcours\Entity\TransitionRecommandee();
		$transition5->narration = "Vers les usages de l'informatique";
		$transition5->semantique = $semantique_chronologie;
		$transition5->scene_origine = $scene5;
		$transition5->scene_destination = $scene6;
		
		$parcours->addTransition($transition5);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//Septième scène
		//
		$scene7 = new Parcours\Entity\SceneRecommandee();
		$scene7->titre = "Développement de l'industrie";
		$scene7->narration = "
				Les années 1965-1980 voient d'importants changements dans l'industrie informatique à Grenoble : développements nombreux, mais aussi fortes perturbations.
				<br><br>
				La compétence acquise par la société Mors dans le domaine des calculateurs industriels va être transférée à la Télémécanique, qui développera avec succès une gamme de calculateurs. L'intervention de l'État, dans le cadre  du plan calcul, conduira à une série de fusions et acquisitions, sans bénéfice évident : création de la SEMS, de CII-Honeywell Bull, réintégration de la SEMS dans ce qui deviendra le groupe Bull. À partir de là, aucun ordinateur ne sera plus conçu à Grenoble.
				<br><br>
				Ces péripéties engendrent un effet secondaire sans doute imprévu : le départ d'un certain nombre d'ingénieurs, en désaccord avec les nouvelles orientations. Ceux-ci seront à l'origine de la création de nombreuses \"start-ups\", qui seront les premiers occupants de la ZIRST, parc d'activités de haute technologie créé à Meylan (banlieue de Grenoble) avec le concours actif des collectivités locales.
				<br><br>
				Un événement important est l'implantation à Eybens (banlieue de Grenoble), en 1971, de la société Hewlett-Packard, qui développera également plus tard des activités à L'Île d'Abeau (Isère).
				<br><br>
				Cette période marque également le début des sociétés de service. À Grenoble, la SoGETI, créée en 1967 par des transfuges de la direction commerciale de Bull, va devenir, après croissance interne et acquisitions, un des grands groupes mondiaux du domaine. Une autre création vient d'une entreprise utilisatrice de l'informatique, la Sogreah, dont le département informatique se détachera en 1968 pour créer la société 3I (Institut International d'Informatique). Celle-ci sera rapidement rachetée (en 1971) par la CGE (Compagnie Générale d’Électricité, futur Alcatel) pour former la GSI (Générale de Services Informatiques) spécialisée dans l'infogérance (externalisation de services informatiques) et basée à Paris. La GSI sera elle-même plus tard reprise par le groupe américain ADP.
				<br><br>
				Sur le front des semi-conducteurs, le service électronique du CENG, qui a acquis une grande compétence dans la conception de circuits intégrés, devient un département autonome au sein du CEA, le LETI (Laboratoire d'Électronique et de Technologie de l'Information). Le LETI sera désormais un acteur majeur dans l'industrie des semi-conducteurs et plus tard des micro- et nano-technologies. En 1972, il crée une entreprise destinée à valoriser ses résultats, EFCIS (Étude et Fabrication de Circuits Intégrés Spéciaux). Parallèlement, sous l'égide de Thomson, est créée la SESCOSEM (fusion de SESCO et COSEM). Le CNET, enfin, décide de développer sa propre filière de circuits intégrés et crée à cet effet en 1979, sur la ZIRST de Meylan, le centre Norbert Ségard.
				<br><br>
				Il faudra attendre la décennie suivante pour que tous ces efforts convergent vers l'émergence d'un grand acteur de l'industrie des semi-conducteurs.
		";
		$scene7->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene7);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//Transition scene6->scene7
		//
		$transition6 = new Parcours\Entity\TransitionRecommandee();
		$transition6->narration = "Vers le développement de l'industrie";
		$transition6->semantique = $semantique_chronologie;
		$transition6->scene_origine = $scene6;
		$transition6->scene_destination = $scene7;
		
		$sous_parcours_developpement->addTransition($transition6);
		$manager->flush();
	
		//
		// Deuxième sous-parcours
		// Huitième scène
		//
		$scene8 = new Parcours\Entity\SceneRecommandee();
		$scene8->titre = "Hauts et bas de la recherche";
		$scene8->narration = "
				Les années 1965-1980 sont une période mouvementée pour la recherche en informatique à Grenoble.
				<br><br>
				D'un côté, l'IMAG connaît un fort développement au début de la période, avec une extension et un approfondissement de son champ de recherche, ainsi qu'une ouverture vers les collaborations industrielles avec les centres scientifiques (IBM puis CII).
				<br><br>
				D'un autre côté, à partir de 1974, la recherche publique est durement touchée par les restrictions budgétaires qui suivent le premier choc pétrolier. S'y ajoutent les limitations sur l'achat de matériel imposées par la politique à courte vue du plan calcul. Enfin, l'arrêt du projet de réseau Cyclades met un terme à une activité qui connaissait des débuts prometteurs.
				<br><br>
				Le laboratoire IMAG connaît par ailleurs à la fin des années 1970 une crise de croissance qui conduira ses autorités de tutelle à lui imposer, en 1982, un découpage en plusieurs laboratoires thématiques.
				<br><br>
				Malgré ces vicissitudes, la recherche parvient à préserver son potentiel et enregistre quelques avancées significatives.
				";
		$scene8->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene8);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//Transition scene7->scene8
		//
		$transition7 = new Parcours\Entity\TransitionRecommandee();
		$transition7->narration = "Vers les hauts et bas de la recherche";
		$transition7->semantique = $semantique_chronologie;
		$transition7->scene_origine = $scene7;
		$transition7->scene_destination = $scene8;
		
		$sous_parcours_developpement->addTransition($transition7);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		// Neuvième scène
		//
		$scene9 = new Parcours\Entity\SceneRecommandee();
		$scene9->titre = "La formation";
		$scene9->narration = "
				Au milieu des années 1960, l'informatisation des entreprises progresse rapidement. C'est aussi le début de l'industrie des services en informatique. Il y a donc une forte demande de personnel qualifié, alors que la formation est encore peu développée.
				<br><br>
				C'est pour répondre à cette demande que sont créées en 1966 deux formations originales à vocation professionnelle : les Instituts de programmation de Paris et de Grenoble. Il s'agit d'un cursus en deux ans, accueillant des étudiants sortis du premier cycle (bac+2), avec sélection des candidatures, et conduisant aux diplômes de Programmeur d'études (première année) et Programmeur expert en systèmes informatiques (deuxième année). Ces diplômes seront rapidement connus et appréciés sur le marché de l'emploi. L'Institut de programmation de Grenoble, initialement dirigé par Noël Gastinel, fonctionnera avec succès jusqu'en 1984, date à laquelle il sera transformé en Maîtrise de sciences et techniques (MST), sans changer de mode de fonctionnement. En 2001, cette MST laissera la place à une formation d'ingénieurs dans le cadre du réseau Polytech.
				<br><br>
				Alors que les Instituts de programmation sont orientés vers la technique, un autre cursus, celui-ci associant informatique, économie et gestion, est créé au plan national au début des années 1970 : la maîtrise MIAGE (Méthodes informatiques appliquées à la gestion des entreprises). La MIAGE de Grenoble, initialement dirigée par Claude Delobel, ouvre en 1972 et fonctionne toujours aujourd'hui.
				<br><br>
				Les Instituts Universitaires de Technologie, ou IUT (formation professionnelle en deux ans, post-baccalauréat) sont mis en place en 1966. L'IUT de Grenoble comporte un département d'informatique, créé et initialement dirigé par Louis Bolliet. En 1970, lors de la création des nouveaux établissements issus de l'université de Grenoble, l'IUT abritant ce département sera rattaché à l'université de sciences sociales (aujourd'hui université Pierre Mendès France), les autres formations universitaires en informatique étant à l'université scientifique, technologique et médicale (aujourd'hui université Joseph Fourier).
				<br><br>
				L'ENSIMAG (créée en 1960) poursuit son développement au sein de l'IPG (devenu en 1969 Institut national polytechnique de Grenoble, aujourd'hui Grenoble INP). Les promotions passent de 40 élèves en 1965 à 60 en 1972, pour atteidre 120 en 1980. Jusque vers 1975, une partie des cours sont encore communs avec ceux de la Maîtrise d'informatique. La croissance des effectifs conduit ensuite à séparer les deux formations.
				<br><br>
				<blockquote>
				En résumé, en 1975, Grenoble affiche une gamme complète de formations en informatique, tant fondamentales (maîtrise, 3ème cycle) que professionnelles (techniciens et techniciens supérieurs, ingénieurs), répartie sur trois établissements. Mise en place au gré de réformes successives et au prix d'un gros effort de la part d'un personnel encore peu nombreux, cette organisation est complexe et sans doute pas optimale du point de vue de la lisibilité et de l'usage des moyens, mais elle répond globalement aux besoins. Elle s'appuie sur le fonds commun de compétences et de connaissances développé au sein de l'IMAG.
				</blockquote>
				";
		$scene9->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene9);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//Transition scene8->scene9
		//
		$transition8 = new Parcours\Entity\TransitionRecommandee();
		$transition8->narration = "Vers les hauts et bas de la recherche";
		$transition8->semantique = $semantique_chronologie;
		$transition8->scene_origine = $scene8;
		$transition8->scene_destination = $scene9;
		
		$sous_parcours_developpement->addTransition($transition8);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Dixième scène
		//
		$scene10 = new Parcours\Entity\SceneRecommandee();
		$scene10->titre = "Usages de l'informatique";
		$scene10->narration = "
				Le début des années 1980 voit une mutation profonde des usages de l'informatique, sous une double influence.
				<ol>
				    <li>L'accès généralisé aux réseaux, et spécialement à l'Internet, qui amorce la fusion entre informatique et télécommunications.
				    </li>
					<li>La large diffusion des ordinateurs personnels, qui conduit à l'avènement de la bureautique.
					</li>
				</ol>
				Ces avancées reposent sur des travaux de recherche et développement menés dans les années 1970. Le phénomène nouveau est leur pénétration universelle, qui va transformer les métiers et les conditions de travail. En parallèle, apparaît la notion de système d'information, support des connaissances, de la communication et des processus de travail au sein d'une entreprise, qui oblige à repenser l'organisation même de l'entreprise.
				<br><br>
				Le fonctionnement centralisé de l'informatique, sous le contrôle d'un centre de calcul fermé, laisse la place à un schéma beaucoup plus ouvert : le service informatique gère les serveurs, distribue et maintient les logiciels, et assure l'administration des réseaux, mais l'informatique \"cliente\", ordinateurs individuels et stations de travail, est proche des utilisateurs finaux et passe progressivement sous leur contrôle.
				<br><br>
				Cette période voit aussi une transformation de la communication : la messagerie électronique s'impose rapidement pour les échanges, et les documents deviennent numériques.
				<br><br>
				L'invention du World Wide Web en 1991 et surtout la diffusion des navigateurs et moteurs de recherche à partir de 1993-94 vont réellement faire pénétrer l'Internet dans le grand public et ouvrir l'ère des services.
				<br><br>
				<blockquote>
					Étant donné la large place que tient l'informatique dans le paysage grenoblois, ces évolutions y seront très visibles, tant dans la recherche et la formation que dans l'industrie. La montée en puissance des réseaux sera un aspect important : en témoigne la création en 1994 de Grenoble Network Initiative (devenu Grilog en 2007) club de réflexion et d'échanges pour l'industrie, la recherche et les collectivités locales autour des technologies de l'information et de la communication. Cette même année est créé le World Wide Web Consortium (W3C), organisme de normalisation pour les produits et services liés au Web. Le centre INRIA de Grenoble sera choisi en 1995 pour accueillir le pôle européen du W3C.
				</blockquote>
				";
		$scene10->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->scene_depart = $scene10;
		$sous_parcours_changement->addScene($scene10);
		$manager->flush();
		
		//
		// Transition entre deux sous-parcours
		// Transition scene9->scene10
		//
		$transition9 = new Parcours\Entity\TransitionRecommandee();
		$transition9->narration = "Vers les usages de l'informatique";
		$transition9->semantique = $semantique_chronologie;
		$transition9->scene_origine = $scene9;
		$transition9->scene_destination = $scene10;
		
		$parcours->addTransition($transition9);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Onzième scène
		//
		$scene11 = new Parcours\Entity\SceneRecommandee();
		$scene11->titre = "Mutations dans l'industrie";
		$scene11->narration = "
				Les années 1980-1995 voient la pénétration de l'informatique dans un nombre croissant d'activités, ce qui a une double conséquence : l'émergence de nouveaux domaines d'application (comme la santé) et la transformation de nombreux métiers. Les sociétés de service se renforcent pour répondre à l'explosion de la demande. Si les plus grandes évoluent vers une fonction de conseil, de nombreuses \"start-up\" se créent sur des créneaux spécialisés.
				<br><br>
				La conception et la réalisation de circuits intégrés se concentrent en majorité dans quelques grands groupes, ce qui n'empêche pas des petites sociétés spécialisés de développer des circuits à la demande pour des usages spéciaux.
				<br><br>
				Le métier de constructeur d'ordinateur évolue fortement sur cette période. Dans les années 1980, c'est l'apparition des ordinateurs individuels, des stations de travail et des serveurs, ainsi que le recul progressif des \"mainframes\" traditionnels. À la fin des années 1980, le PC (ou plutôt ses clones, assemblés à bas coût) est le standard pour la grande majorité des ordinateurs personnels, tant dans les entreprises que dans le grand public.
				<br><br>
				Cette évolution est illustrée, à Grenoble, par l'activité des grands groupes, l'arrivée de nouveaux acteurs, la création de \"start-ups\", et la concentration dans le domaine des circuits intégrés.
				";
		$scene11->elements = new \Doctrine\Common\Collections\ArrayCollection();

		$sous_parcours_changement->addScene($scene11);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//Transition scene10->scene11
		//
		$transition10 = new Parcours\Entity\TransitionRecommandee();
		$transition10->narration = "Vers les mutations dans l'industrie";
		$transition10->semantique = $semantique_chronologie;
		$transition10->scene_origine = $scene10;
		$transition10->scene_destination = $scene11;
		
		$sous_parcours_changement->addTransition($transition10);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Douzième scène
		//
		$scene12 = new Parcours\Entity\SceneRecommandee();
		$scene12->titre = "Un nouvel élan pour la recherche";
		$scene12->narration = "
				La période 1980-95 est initialement perturbée, mais va ensuite voir un nouvel élan pour la recherche, marqué par des événements significatifs :
				<ol>
				    <li>La création à Grenoble en 1992 d'une nouvelle unité de recherche de l'INRIA (Institut national de recherche en informatique et automatique).
					</li>    
					<li>L'installation de plusieurs laboratoires d'entreprises ou de consortiums internationaux (Sun Microsystems, Xerox, OSF), qui témoignent de l'attractivité du pôle grenoblois de recherche et de formation en informatique.
				    </li>
					<li>La création d'unités mixtes de recherche, outils de collaboration entre recherche publique et industrie.
					</li>
				</ol>
				Les restrictions sur l'achat de matériel, imposées dans le cadre du plan calcul, sont levées en 1981, ce qui permettra aux laboratoires de s'équiper en matériel conforme à l'état de l'art.
				<br><br>
				Il faut aussi noter l'instauration, en 1983, du programme européen ESPRIT (European Strategic Program on Research in Information Technology) qui apportera des financements significatifs à de nombreux  projets de recherche grenoblois et contribuera au développement de la coopération internationale.
				<br><br>
				Malgré les divers changements institutionnels, consommateurs de temps et d'énergie, cette période va enregistrer de belles avancées dans le domaine de la recherche et de sa valorisation.
				";
		$scene12->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene12);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//Transition scene11->scene12
		//
		$transition11 = new Parcours\Entity\TransitionRecommandee();
		$transition11->narration = "Vers un nouvel élan pour la recherche";
		$transition11->semantique = $semantique_chronologie;
		$transition11->scene_origine = $scene11;
		$transition11->scene_destination = $scene12;
		
		$sous_parcours_changement->addTransition($transition11);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Treizième scène
		//
		$scene13 = new Parcours\Entity\SceneRecommandee();
		$scene13->titre = "La formation";
		$scene13->narration = "
				La formation en informatique et dans les domaines connexes continue à évoluer dans la période 1980-1995 pour répondre à une demande toujours croissante, ainsi qu'à l'évolution technique.
				<br><br>
				En 1981 est créé le Centre Interuniversitaire de microélectronique (CIME), à l'initiative conjointe de l'Institut National Polytechnique de Grenoble (INPG) et de l'université Joseph Fourier (UJF). Le CIME (photo ci-contre) a pour vocation de fournir les moyens nécessaires à l'enseignement et à la recherche dans le domaine de la microélectronique. Il s'agit de moyens lourds faisant appel à des techniques avancées (conception, caractérisation et test de circuits, salles blanches). À partir de 2002, le CIME sera le pôle principal d'un groupement coordonnant les activités de 12 centres de formation existant alors en France dans le même domaine (qui sera étendu aux nanotechnologies).
				<br><br>
				L'Institut de programmation de Grenoble, qui fonctionnait sous un régime spécifique, prend en 1984 le statut de Maîtrise de sciences et techniques, ce qui lui permet de délivrer un diplôme national.
				<br><br>
				En 1984 également sont créés à l'UJF deux Diplômes d'études supérieures spécialisées (DESS) en informatique. Il s'agit de formations professionnelles de niveau bac+5 recrutant leurs étudiants par sélection sur dossier, et faisant une place importante aux stages en entreprise. En 2002, avec la réforme des études supérieures, ces formations s'inséreront dans le cursus du Master.
				<ol>
				    <li>Le DESS de Génie informatique s'adresse à des étudiants ayant déjà une formation de base en informatique, du niveau de la Maîtrise. Il donne une formation approfondie centrée sur la technique (génie logiciel, systèmes et réseaux, bases de données, communication homme-machine, etc.).
				    </li>
					<li>Le DESS \"Double compétence en informatique\" (qui deviendra plus tard \"Compétence complémentaire\") s'adresse à des étudiants ayant acquis une formation du niveau de la Maîtrise dans un domaine autre que l'informatique, et désirant acquérir une formation supplémentaire dans cette discipline. En fait, en raison de la forte demande, la plupart des diplômés de cette formation effectueront une conversion totale vers l'informatique.
					</li>
				</ol>
				Des filières de formation incluant l'informatique sont par ailleurs créées dans d'autres environnements. Ainsi un DESS \"Double compétence en informatique et sciences sociales\" est  créé en 1984 à l'université Pierre Mendès France (université de sciences sociales). Une Maîtrise de sciences et techniques \"Informatique industrielle et instrumentation\" (3I) est créée en 1985 à l'UJF par des physiciens (elle deviendra plus tard une formation d'ingénieur dans le cadre du réseau Polytech).
				<br><br>
				Dans le cadre de l'INPG, l'ENSIMAG continue sa croissance (promotions de 130 élèves en 1995) et diversifie ses options.
				<br><br>
				<blockquote>
					À la fin de la période (1995), les établissements d'enseignement supérieur de Grenoble comptent au total plus de 1 000 étudiants en informatique et mathématiques appliquées, l'informatique étant largement dominante.
				</blockquote>
				";
		$scene13->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene13);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//Transition scene12->scene13
		//
		$transition12 = new Parcours\Entity\TransitionRecommandee();
		$transition12->narration = "Vers la formation";
		$transition12->semantique = $semantique_chronologie;
		$transition12->scene_origine = $scene12;
		$transition12->scene_destination = $scene13;
		
		$sous_parcours_changement->addTransition($transition12);
		$manager->flush();
		
			/********************************
			 *	Parcour n°2
			 ********************************/


		/*
		 * Quelques artefacts et sémantiques pour remplir les scènes
		 */
		
		$type_artefact_personne = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Institution'));
		$jean_kuntzmann = new Collection\Entity\Artefact(null, $type_artefact_personne);
		$jean_kuntzmann->populate(null);
		$jean_kuntzmann->titre = 'La machine de Schickard';
		$jean_kuntzmann->description = "Wilhelm Schickard (1592-1635) était un pasteur luthérien allemand, qui devint professeur d'hébreu, puis d’astronomie à l’université de Tübingen. En 1623 et 1624, il décrit, dans des lettres adressées à Kepler, une machine à calculer de son invention, capable de faire des additions et des soustractions sur des nombres jusqu’à 6 chiffres. La multiplication et la division étaient réalisées à l’aide de bâtons de Napier, mais l'opérateur devait gérer lui-même le stockage de résultats intermédiaires.
<br>
Schickard fit construire en 1624 un prototype de sa machine, mais celui-ci fut détruit dans un incendie avant d’avoir été terminé, et ne fut pas reconstruit.
		";
		$manager->persist($jean_kuntzmann);
		
		$type_artefact_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$gamma_3 = new Collection\Entity\Artefact(null, $type_artefact_materiel);
		$gamma_3->populate(null);
		$gamma_3->titre = 'La Pascaline';
		$gamma_3->description = "
				La pascaline est une machine à calculer mécanique inventée en 1642 par Blaise Pascal (1623-1662). Cette machine, qui pouvait faire les additions et les soustractions, fut construite en une vingtaine d’exemplaires, dont neuf ont survécu jusqu’à nos jours (quatre d’entre eux sont exposés au Musée des Arts et Métiers, à Paris).
<br>
Blaise Pascal inventa sa machine pour aider son père, surintendant et percepteur de taxes, à faire ses calculs. La machine ne connut pas de succès commercial en raison de son prix élevé. Pascal avait l’intention de développer une machine plus simple et plus accessible, mais ce projet fut abandonné quand il cessa son activité scientifique en 1654 à la suite d’un accident.
<br>
La pascaline est considérée comme la première machine à calculer mécanique numérique. Wilhelm Schickard avait conçu en 1623 un calculateur fondé sur un principe différent, mais cette machine n’a jamais fonctionné. La pascaline inspira divers travaux ultérieurs, dont la machine de Leibniz (1671), qui pouvait faire des multiplications et des divisions, et qui est l’ancêtre des calculatrices construites jusqu’à la fin du 20ème siècle.
		";
		$manager->persist($gamma_3);
		
		$type_artefact_personne = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$rene_perret = new Collection\Entity\Artefact(null, $type_artefact_personne);
		$rene_perret->populate(null);
		$rene_perret->titre = 'La machine de Leibniz';
		$rene_perret->description = "
				En 1672, lors d’un voyage à Paris, Leibniz découvre la pascaline, calculateur mécanique pouvant faire les additions et soustractions. Il conçoit alors l’idée d’une machine pouvant également réaliser les multiplications et divisions. On pense que deux machines seulement ont été construites à l’époque de Leibniz, l’une entre 1686 et 1694, l’autre entre 1690 et 1720. Cette dernière a survécu et se trouve à la Niedersächsische Landesbibliothek à Hanovre. Des répliques fonctionnelles en ont été réalisées (ci contre, copie conservée au Technische Sammlungen Museum à Dresde). La complexité du mécanisme était à la limite des capacités de réalisation mécanique de l’époque.
<br>
La machine de Leibniz, et en particulier le mécanisme du cylindre, est la source principale d’inspiration pour les calculatrices numériques ultérieures. On pense néanmoins que le principe du cylindre a pu être redécouvert indépendamment par certains inventeurs.
		";
		$manager->persist($rene_perret);
		
		$type_artefact_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$MAT_01 = new Collection\Entity\Artefact(null, $type_artefact_materiel);
		$MAT_01->populate(null);
		$MAT_01->titre = 'Arithmomètres et calculatrices';
		$MAT_01->description = "Au cours du 18ème siècle, plusieurs inventeurs (Poleni, Hahn, Stanhope et d’autres) développèrent des calculateurs mécaniques, en utilisant le cylindre de Leibniz ou des mécanismes équivalents. Mais ces expériences eurent peu de retombées. Il fallut attendre 1820 pour une avancée décisive, l’arithmomètre de Thomas de Colmar. On peut noter qu’à la même époque Charles Babbage travaillait sur sa machine à différences, qui, trop en avance sur son époque, ne put être réalisée.
<br>
Charles-Xavier Thomas, connu sous le nom de Thomas de Colmar, après un bref passage dans l’armée comme officier d’administration, créa et dirigea plusieurs compagnies d'assurances. Parallèlement, il développa plusieurs versions de l’arithmomètre et lança sa fabrication en série en 1851.
<br>
L’arithmomètre s'inspire de la machine de Leibniz, mais introduit diverses améliorations : utilisation de curseurs au lieu de roues pour l’inscription des opérandes, mécanisme correct et automatique pour le report de la retenue, inversion des parties fixe et mobile par rapport à la machine de Leibniz (le bloc des inscripteurs devenant fixe et celui des totalisateurs, plus léger, devenant mobile). Cette machine est fabriquée en série et commercialisée, jusqu’en 1914. L’exemplaire représenté ci-contre (source) date de 1887.";
		$manager->persist($MAT_01);
		
		
		
		/*
		 * Parcours, Sous-parcours
		 */
		$parcours = new Parcours\Entity\Parcours();
		$parcours->titre = "Préhistoire (avant 1935)";
		$parcours->description = "Les machines, du supercalculateur à la tablette ou au  smartphone, sont la manifestation la plus visible de l’informatique. Nous proposons ci-dessous plusieurs parcours, à la fois chronologiques et thématiques, pour illustrer leur histoire. Mais celle-ci est indissociable d’autres thèmes, eux aussi objet de parcours spécialisés : Technologie, Systèmes d'exploitation, Réseaux, entre autres. 
<br>
Les dates indiquées ne sont qu’approximatives. Elles permettent de situer en gros l’époque des développements présentés.
		";
		$parcours->sous_parcours = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_debut = new Parcours\Entity\SousParcours();
		$sous_parcours_debut->titre = "Du boulier à la tabulatrice";
		$sous_parcours_debut->description = "
Les machines mécaniques, du boulier à la tabulatrice.
";
		$sous_parcours_debut->scenes = new \Doctrine\Common\Collections\ArrayCollection();
		$sous_parcours_debut->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		
		$parcours->addSousParcours($sous_parcours_debut);
		
		$manager->persist($parcours);
		$manager->flush();
		
		/*
		 * Première scène
		 */
		$scene1 = new Parcours\Entity\SceneRecommandee();
		$scene1->titre = "Du boulier à la tabulatrice";
		$scene1->narration = "
				<p>Le boulier est l’ancêtre des machines ”numériques” (en anglais <em>digital</em>), dans lesquelles l’information est représentée sous forme discrète, c’est à dire modifiable par sauts discontinus (une boule du boulier, un bit dans la mémoire d’un ordinateur), par opposition aux machines “analogiques”, dans lesquelles l’information varie de manière continue (comme une longueur, un angle, une tension électrique). Voir plus de détails sur les <span style=\"color: #0000ff; font-size: small; font-family: trebuchet ms,geneva;\"><a href=\"http://aconit.inria.fr/omeka/exhibits/show/histoire-machines/machines-analogiques\" target=\"_blank\"><span style=\"color: #0000ff;\">machines analogiques</span></a></span>, avec quelques <span style=\"color: #0000ff;\"><a href=\"http://aconit.inria.fr/omeka/exhibits/show/collections-aconit/machines-analogiques\" title=\"Machines analogiques\" target=\"_blank\"><span style=\"color: #0000ff;\">exemples</span></a></span>.</p>

<p></p>
<p></p>
<p>Voici quelques étapes marquantes de l’évolution des machines mécaniques numériques.</p>
<ul>
<li>Les <span style=\"color: #0000ff;\"><a href=\"http://aconit.inria.fr/omeka/exhibits/show/histoire-machines/prehistoire/les-premiers-calculateurs-m--c\" title=\"Calculateurs mécaniques\" target=\"_blank\"><span style=\"color: #0000ff; font-size: small;\">machines mécaniques</span></a></span> du 17ème siècle, capables d’effectuer des additions et soustractions (Schickard, Pascal), puis des multiplications et divisions (Leibniz).</li>
<li>Les <span style=\"color: #0000ff;\"><a href=\"http://aconit.inria.fr/omeka/exhibits/show/histoire-machines/prehistoire/arithmometres\" title=\"L’arithmomètre\" target=\"_blank\"><span style=\"color: #0000ff; font-size: small;\">arithmomètres</span></a></span>, machines dérivées de celle de Leibniz et progressivement perfectionnées. Ces machines mécaniques sont les ancêtres des calculatrices électromécaniques qui seront utilisées jusqu'au 20ème siècle.</li>
<li>Les machines mécaniques inventées par <span style=\"color: #0000ff; font-family: trebuchet ms,geneva; font-size: small;\"><a href=\"http://aconit.inria.fr/omeka/exhibits/show/figures-de-l-informatique/precurseurs/charles-babbage\" title=\"Charles Babbage\" target=\"_blank\"><span style=\"color: #0000ff;\"><span style=\"color: #0000ff; font-size: small;\">Charles Babbage</span></span></a></span> au 19ème siècle : un calculateur spécialisé (la <span style=\"color: #0000ff;\"><a href=\"http://aconit.inria.fr/omeka/exhibits/show/histoire-machines/prehistoire/machine-differences\" title=\"Machine à différences\" target=\"_blank\"><span style=\"color: #0000ff; font-size: small;\">machine à différences</span></a></span>) et un calculateur universel, préfigurant les ordinateurs (la <span style=\"color: #0000ff;\"><a href=\"conit.inria.fr/omeka/exhibits/show/histoire-machines/prehistoire/machine-analytique\" title=\"Machine analytique\" target=\"_blank\"><span style=\"color: #0000ff; font-size: small;\">machine analytique</span></a></span>). Ces machines restèrent à l'état de plan. Un exemplaire de la machine à différences a été construit à la fin du 20ème siècle.</li>
<li>Les machines mécanographiques, inventées par <span style=\"color: #0000ff; font-size: 11px; font-family: arial,helvetica,sans-serif;\"><a href=\"http://aconit.inria.fr/omeka/exhibits/show/figures-de-l-informatique/precurseurs/herman-hollerith\" title=\"Herman Hollerith\" target=\"_blank\"><span style=\"color: #0000ff;\">Herman Hollerith</span></a> </span>à la fin du 19ème siècle. Outre les calculs, ces machines réalisaient des opérations telles que le tri de données. Cette invention fut à la base du développement d'une industrie, qui réalisa au début des années 1950 sa <span style=\"color: #0000ff; font-family: arial,helvetica,sans-serif; font-size: 11px;\"><a href=\"http://aconit.inria.fr/omeka/exhibits/show/collections-aconit/mecanographie/mecanographie-informatique\" title=\"Transition vers l’informatique\" target=\"_blank\"><span style=\"color: #0000ff;\">transition vers l’informatique</span></a></span>.</li>
</ul>
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
		$scene2->titre = "Les calculateurs mécaniques";
		$scene2->narration = "
				Les débuts du calcul mécanique numérique sont lents : entre le boulier (apparu dans l’antiquité, dans divers pays), et les bâtons de Napier, ou Neper (1617), on n’enregistre pas de progrès décisif. Mais le 17ème siècle voit la naissance des calculateurs mécaniques : Schickard (1623) et Pascal (1642) conçoivent des machines pouvant  réaliser les additions et les soustractions. La machine de Leibniz (1694), qui étend celle de Pascal, est en outre capable de faire les multiplications et les divisions. À la même époque, le calcul analogique progresse avec l’invention de la règle à calcul.
<br>
La machine de Leibniz est à l’origine de l’industrie des calculatrices mécaniques, puis électromécaniques, qui sera active jusqu’à la fin du 20ème siècle. 
<br>
Dans le courant du 18ème siècle, plusieurs calculateurs mécaniques sont construits, inspirés de ceux de Pascal et de Leibniz, mais ils ne dépassent pas le stade de prototypes. En 1820, Thomas de Colmar construit l’arithmomètre, qui marque le début du développement de l’industrie des calculatrices mécaniques. En 1873, Odhner remplace le cylindre de Leibniz par un mécanisme équivalent, plus léger, et ce principe est utilisé par de nombreuses réalisations industrielles. Au début du 20ème siècle, la manivelle qui actionne la machine est remplacée par un moteur électrique et l’interface s’améliore avec le clavier à touches. Puis apparaissent les imprimantes intégrées. Les calculatrices mécaniques sont produites à des millions d’exemplaires dans le courant du 20ème siècle.
<br>
L’apparition, dans les années 1950, des premiers ordinateurs, marque le début du déclin des  calculatrices mécaniques et électromécaniques, qui ont pratiquement disparu dans les années 1970. Les calculettes (calculatrices miniaturisées électroniques, à base de microprocesseurs) prendront ensuite la relève. Il existe encore un marché pour des calculatrices électroniques de bureau, en particulier pour celles spécialisées dans un domaine particulier (par exemple calculatrices financières).
<br>
En marge de ces développements, Charles Babbage conçoit entre 1820 et 1850 des machines mécaniques révolutionnaires, la machine à différences et la machine analytique. Cette dernière, capable en théorie d’exécuter tout algorithme, préfigure l’ordinateur. Mais ces machines, très en avance sur leur époque, resteront à l’état de plans et ne connaîtront que des réalisations très partielles.
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
		$transition1->narration = "Vers Les calculateurs mécaniques";
		$transition1->semantique = $semantique_chronologie;
		$transition1->scene_origine = $scene1;
		$transition1->scene_destination = $scene2;
		
		$sous_parcours_debut->addTransition($transition1);
		$manager->flush();
		
		/*
		 * Troisième scène
		*/
		$scene3 = new Parcours\Entity\SceneRecommandee();
		$scene3->titre = "Les machines de Babbage";
		$scene3->narration = "
				
		";
		$scene3->elements = new \Doctrine\Common\Collections\ArrayCollection();
		$scene3->elements->add($cours);
		
		$sous_parcours_debut->addScene($scene3);
		$manager->flush();
		
		/*
		 * Transition scene2->scene3
		*/		
		$transition2 = new Parcours\Entity\TransitionRecommandee();
		$transition2->narration = "Les machines de Babbage";
		$transition2->semantique = $semantique_chronologie;
		$transition2->scene_origine = $scene2;
		$transition2->scene_destination = $scene3;
		
		$sous_parcours_debut->addTransition($transition2);
		$manager->flush();
		
		



	}
}
