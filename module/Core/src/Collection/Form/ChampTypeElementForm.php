<?php

namespace Collection\Form;

use Zend\Form\Form;
use InvalidArgumentException;
use Collection\Entity\TypeElement;

class ChampTypeElementForm extends Form
{
	public function __construct($type_element, $name = null)
	{
		if (!$type_element instanceof TypeElement) {
			throw new InvalidArgumentException('Construction d\'un formulaire TypeElementForm avec un param�tre qui n\'est pas de type TypeElement');
		}
		parent::__construct('champtypeelement');
		$this->setAttribute('method', 'post');

		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'type'  => 'hidden',
			),
		));
		
		foreach ($type_element->champs as $champ) {
			echo $champ->label;
			switch ($champ->format) {
				case 'texte':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array('type'  => 'text'),
						'options' => array('label' => $champ->label),
					));
					break;
				case 'date':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array('type'  => 'date'),
						'options' => array('label' => $champ->label),
					));
					break;
				case 'nombre':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array('type'  => 'number'),
						'options' => array('label' => $champ->label),
					));
					break;
				case 'fichier':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array('type'  => 'file'),
						'options' => array('label' => $champ->label),
					));
					break;
				case 'url':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array('type'  => 'url'),
						'options' => array('label' => $champ->label),
					));
			} // end switch
			
		} // end foreach

		
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
					'type'  => 'submit',
					'value' => 'Go',
					'id' => 'submitbutton',
				),
		));
		
	}
	
}
