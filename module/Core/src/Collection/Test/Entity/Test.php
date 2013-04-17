<?php
namespace Collection;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Core\Collection\Entity\Champ;

use PHPUnit_Framework_TestCase;

class Test extends PHPUnit_Framework_TestCase
{
	
	private function constructeurTypeElement($type) {
		$type_element = new Entity\TypeElement('Exemple de type d\'élément', $type);
		$this->assertEquals($type_element->__get('nom'), 'Exemple de type d\'élément');
		$this->assertEquals($type_element->__get('type'), $type);
		$this->assertEmpty($type_element->__get('champs'));
	}	
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurTypeElementError() {
		$this->constructeurTypeElement('Type Interdit');
	}
	
	public function testConstructeurTypeElementOK() {
		$this->constructeurTypeElement('artefact');
		$this->constructeurTypeElement('media');
	}
	
	private function constructeurChamp($format) {
		$type_element_artefact = new Entity\TypeElement('Exemple de type d\'élément caractérisant un artefact', 'artefact');
		$champ_artefact = new Entity\Champ('Exemple de label', $type_element_artefact, $format);
		$this->assertEquals($champ_artefact->__get('label'), 'Exemple de label');
		$this->assertEquals($champ_artefact->__get('type_element'), $type_element_artefact);
		$this->assertEquals($champ_artefact->__get('type_element')->__get('type'), 'artefact');
		$this->assertEquals($champ_artefact->__get('format'), $format);
		
		$type_element_media = new Entity\TypeElement('Exemple de type d\'élément caractérisant un artefact', 'media');
		$champ_media = new Entity\Champ('Exemple de label', $type_element_media, $format);
		$this->assertEquals($champ_media->__get('label'), 'Exemple de label');
		$this->assertEquals($champ_media->__get('type_element'), $type_element_media);
		$this->assertEquals($champ_media->__get('type_element')->__get('type'), 'media');
		$this->assertEquals($champ_media->__get('format'), $format);
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurChampError() {
		$this->constructeurChamp('Format Interdit');
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurChampError2() {
		$this->constructeurChamp(34);
	}
	
	public function testConstructeurChampOK() {
		$this->constructeurChamp('texte');
		$this->constructeurChamp('date');
		$this->constructeurChamp('fichier');
		$this->constructeurChamp('nombre');
		$this->constructeurChamp('url');
	}
	
	private function constructeurArtefact($type) {
		$type_element = new Entity\TypeElement('Exemple de type d\'élément', $type);
		$artefact = new Entity\Artefact('Exemple d\'artefact', $type_element);
		$this->assertEquals($artefact->__get('titre'), 'Exemple d\'artefact');
		$this->assertEquals($artefact->__get('type_element'), $type_element);
		$this->assertNull($artefact->__get('datas'));
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurArtefactError() {
		$this->constructeurArtefact('media');
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurArtefactError2() {
		$this->constructeurArtefact('Type Interdit');
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurArtefactError3() {
		$this->constructeurArtefact(3);
	}
	
	public function testConstructeurArtefactOK() {
		$this->constructeurArtefact('artefact');
	}
	
	private function constructeurMedia($type) {
		$type_element = new Entity\TypeElement('Exemple de type d\'élément', $type);
		$media = new Entity\Media('Exemple de média', $type_element);
		$this->assertEquals($media->__get('titre'), 'Exemple de média');
		$this->assertEquals($media->__get('type_element'), $type_element);
		$this->assertNull($media->__get('datas'));
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurMediaError() {
		$this->constructeurMedia('artefact');
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurMediaError2() {
		$this->constructeurMedia('Type Interdit');
	}
	
	public function testConstructeurMediaOK() {
		$this->constructeurMedia('media');
	}
	
}
