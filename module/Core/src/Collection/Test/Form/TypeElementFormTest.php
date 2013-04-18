<?php
namespace Collection\Test;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Collection\Entity\TypeElement;
use Collection\Entity\Champ;
use Collection\Form\TypeElementForm;

use PHPUnit_Framework_TestCase;

class TypeElementFormTest extends PHPUnit_Framework_TestCase
{
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testTypeElementFormError() {
		$form = new TypeElementForm('Argument Invalide');
	}
	
	public function testTypeElementFormOK() {
		$type_element = new TypeElement('Exemple de type d\'artefact', 'artefact');
		$champ1 = new Champ('Label pour le texte', $type_element, 'texte');
		$champ2 = new Champ('Label pour la date', $type_element, 'date');
		$champs = array($champ1, $champ2);
		$type_element->__set('champs', $champs);
		$form = new TypeElementForm($type_element);

		$this->assertNotNull($form->get('Label pour le texte'));
		$this->assertNotNull($form->get('Label pour la date'));
		
	}
	
}
