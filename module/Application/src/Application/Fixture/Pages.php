<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Pages implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		/* ************** *
		 * PAGE D'ACCUEIL *
		 * ************** */

		$page_accueil = new Application\Entity\Page(
			'Accueil',
			"
				<h1>L'association ACONIT</h1>
				<blockquote><i>
				ACONIT, association pour un conservatoire de l'informatique et de la télématique, a été fondée à  Grenoble en 1985 pour créer les structures permettant l'étude et l'illustration de l'évolution de l'informatique, en faisant revivre son histoire passée et en suivant ses développements futurs. La mission d'ACONIT se décline selon 3 modes&nbsp;:
				</i>
				<br>
				<ul>
					<li><i>Conserver et inventorier le patrimoine scientifique. Conserver les savoir-faire et créer des supports de mémoire.</i></li>
					<li><i>Participer et impulser une réflexion sur les aspects théoriques et conceptuels de la science et des techniques informatiques dans leurs développements et leurs implications scientifiques, industrielles et sociétales.</i></li>
					<li><i>Diffuser cette histoire de l'informatique et ces réflexions pour offrir à un large public un accès vivant à la culture scientifique. <br></i></li>
				</ul>
				</blockquote>
				<a target=\"_blank\" rel=\"nofollow\" href=\"http://www.aconit.org\">www.aconit.org</a>
				<br><br>
				L'association Aconit dispose déjà  d'une collection de plusde 2000 machines et de plusieurs milliers de documents et logiciels. 
				
				<h1>Le projet Cervin</h1>
				Le numérique fait partie de notre vie quotidienne et prend une place centrale dans la société moderne. On constate néanmoins que la connaissance qu'en a le grand public reste superficielle. Ce constat vaut spécialement pour les jeunes générations qui, si elles sont familières avec l'usage des outils, ont souvent de l'informatique une image partielle et biaisée. La baisse du nombre d'étudiants s'orientant vers des carrières scientifiques est une menace pour notre compétitivité.
				
				<br><br>Une large diffusion de la culture scientifique et technique liée au numérique paraît donc une tâche prioritaire. La société industrielle a enseigné les bases des sciences de la matière à ses citoyens. Pour donner à chacun(e) toutes ses chances d'y trouver sa place et de réussir, la société de l'information française du XXIe siècle doit permettre l'accès de tous à la culture, aux sciences et aux techniques du numérique. 
				
				<br><br>Pour relever ce défi, CERVIN (Centre de ressources virtuelles pour l'innovation numérique) a été lancé par l'association ACONIT, le CCSTI de Grenoble (La Casemate) et l'INRIA, avec le soutien des collectivités locales (Communauté d'Agglomération Grenoble-Alpes-MÃ©tropole,Ville de Grenoble, Conseil Général de l'Isère), celui du Ministère de l'Enseignement Supérieur et de la Recherche, ainsi que la contribution d'acteurs économiques et des relations partenariales avec le milieu académique. Le projet est porté par F. LETELLIER. JP. VERJUS (Chevalier dans l'Ordre de la Légion d'Honneur, ancien DGA de l'INRIA) en préside le conseil scientifique. S.KRAKOWIAK, professeur émérite d'informatique, anime la communauté éditoriale de CERVIN.
				
				<br><br>CERVIN est un projet de médiation scientifique dans le domaine du numérique. Il favorise la connaissance et la compréhension de la société de l'information à travers son histoire, son actualité et sa prospective, ses sciences, techniques et cultures. Il s'adresse au plus grand nombre, hommes et femmes de toutes générations et de tous profils en s'adaptant à leurs intérêts et usages. Il propose une approche partenariale avec des acteurs de terrain et une implication du public dans des actions de co-construction de contenus. L'utilisation des technologies les plus en pointe du trans-media et des collections numériques promettent aux publics visés une expérience attractive, parfois ludique, parfois pédagogique, et toujours étayée par une collection de référence, validée par la communauté scientifique et accessible dans son intégralité.
				
				<br><br>L'activité de CERVIN s'organise selon quatre modalités :
				<br><br>
				<ul>
					<li>Une communauté éditoriale constituant un large corpus documentaire et une collection numérique de qualité</li>
					<li>Un ou plusieurs laboratoires d'étude, de restauration, de présentation de matériels et logiciels anciens ou récents, de partage d'expériences</li>
					<li>Une chaîne informatique d'acquisition, gestion et diffusion de ressources numériques permettant la constitution et la gestion d'une ou plusieurs oeuvres collectives</li>
					<li>Une démarche pro-active de diffusion des contenus vers de nombreux canaux et, au delà , de nombreux publics, dans un but de médiation scientifique, de diffusion de la culture scientifique et technique, d'éducation et de formation.</li>
				</ul>
				<div>La première étape de CERVIN a été nommée MOVING et consiste à développer une preuve de concept opérationnelle.</div>
				
				<h1>Le back-office de Cervin</h1>
				
				Cette application propose un prototype pour la partie back-office de cette première phase Moving (nom de code Moving-BO). Le back-office se situe au niveau du système de gestion de ressources. Il s'agit d'une application web permettant aux membres de la communauté éditoriale de Cervin de : 
				
				<br><br>
				<ol>
					<li>Alimenter et gérer une collection numérique organisée contenant toutes sortes de ressources illustrant la culture informatique sous différentes formes.</li>
					<li>Organiserles éléments de la collection en <i>parcours</i>, c'est-à-dire en récits porteurs de sens composés de séries d'éléments de la collection numérique.</li>
					<li>Enfin, les données gérés par le back-office (collection numérique et parcours) devront être accessible facilement via une API pour pouvoir les présenter à travers différents canaux au public. Cette partie présentation ne fait pas partie du périmètre du projet Moving-BO.</li>
				</ol><br>
			"
		);
		$manager->persist($page_accueil);
		/* ************** *
		 * PAGE D'ACCUEIL *
		 * ************** */

		$page_contact = new Application\Entity\Page(
			'Contact',
			"
				<h1>Contact</h1>
				Pour toutes vos remarques (bugs, suggestions, ...), le projet Cervin utilise la forge Tuleap. Vous pouvez créer un ticket ici : 
				<a href=\"https://tuleap.cervin.org/plugins/tracker/?tracker=27&func=new-artifact\" title=\"Link: https://tuleap.cervin.org/\">Tuleap</a>
			"
		);
		$manager->persist($page_contact);
		$manager->flush();
	}
}