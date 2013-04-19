<?php
namespace Collection\Test;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Collection\Form\ChampForm;

use PHPUnit_Framework_TestCase;

class ChampFormTest extends PHPUnit_Framework_TestCase
{
	
	public function testTypeElementFormOK() {
		$form = new ChampForm();
		$this->assertNotNull($form->get('label'));
		$this->assertNotNull($form->get('description'));
		$this->assertNotNull($form->get('format'));
	}
	
}
