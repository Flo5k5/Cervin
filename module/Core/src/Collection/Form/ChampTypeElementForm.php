<?php

namespace Collection\Form;

use Zend\Form\Form;
use Zend\Form\Element;
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
		$hidden=new Element\Hidden();
		$hidden->setName('id')
			->setAttributes(array(
				'type'  => 'hidden',
			));
		$this->add($hidden);
		
		foreach ($type_element->champs as $champ) {
			switch ($champ->format) {
				case 'texte':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array('type'  => 'text'),
						'options' => array('label' => $champ->label),
					));
					break;
				case 'textarea':
					$this->add(array(
						'name' => $champ->__get('label'),
						'attributes' => array('type'  => 'textarea'),
						'options' => array('label' => $champ->__get('label'))
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

		$button = new Element\Button('submit');
		$button->setLabel('Valider')
				->setValue('submit')
				->setAttributes(array(
					'type'  => 'submit',
					'value' => 'Valider',
					'id' => 'submitbutton',
					'class' => 'btn btn-primary'
				));
		$this->add($button);
	}
	
}
