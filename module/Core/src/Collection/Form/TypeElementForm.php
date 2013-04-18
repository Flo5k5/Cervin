<?php

namespace Collection;

use Zend\Form\Form;
use InvalidArgumentException;

class TypeElementForm extends Form
{
	public function __construct($type_element, $name = null)
	{
		if (!$type_element instanceof Entity\TypeElement) {
			throw new InvalidArgumentException('Construction d\'un formulaire TypeElementForm avec un paramètre qui n\'est pas de type TypeElement');
		}
		parent::__construct('typeelement');
		$this->setAttribute('method', 'post');

		$this->add(array(
				'name' => 'id',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));
		
		foreach ($type_element->__get('champs') as $champ) {
			
			switch ($champ->__get('format')) {
				case 'texte':
					$this->add(array(
						'name' => $champ->__get('label'),
						'attributes' => array('type'  => 'text'),
						'options' => array('label' => $champ->__get('label'))
					));
					break;
				case 'date':
					$this->add(array(
						'name' => $champ->__get('label'),
						'attributes' => array('type'  => 'date'),
						'options' => array('label' => $champ->__get('label'))
					));
					break;
				case 'nombre':
					$this->add(array(
						'name' => $champ->__get('label'),
						'attributes' => array('type'  => 'number'),
						'options' => array('label' => $champ->__get('label'))
					));
					break;
				case 'fichier':
					$this->add(array(
						'name' => $champ->__get('label'),
						'attributes' => array('type'  => 'file'),
						'options' => array('label' => $champ->__get('label'))
					));
					break;
				case 'url':
					$this->add(array(
						'name' => $champ->__get('label'),
						'attributes' => array('type'  => 'url'),
						'options' => array('label' => $champ->__get('label'))
					));
			} // end switch
			
		} // end foreach

		
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
					'type'  => 'submit',
					'value' => 'Go',
					'id' => 'submitbutton'
				),
		));
		
	}
	
}
