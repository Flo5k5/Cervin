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
			throw new InvalidArgumentException('Construction d\'un formulaire ChampTypeElementForm avec un param�tre qui n\'est pas de type TypeElement');
		}
		parent::__construct('champtypeelement');
		$this->setAttribute('method', 'post');
		$hidden=new Element\Hidden();
		$hidden->setName('id')
			->setAttributes(array(
				'type'  => 'hidden',
				'class' => 'other',
			));
		$this->add($hidden);
		
		foreach ($type_element->champs as $champ) {
			switch ($champ->format) {
				case 'texte':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array(
							'type'  => 'text',
							'description' => $champ->description,
							'class' => 'other',
						),
						'options' => array('label' => $champ->label),
					));
					break;
				case 'textarea':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array(
							'type'  => 'textarea',
							'description' => $champ->description,
							'class' => 'other',
						),
						'options' => array('label' => $champ->label),
					));
					break;
				case 'date':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array(
							'type'  => 'text',
							'description' => $champ->description,
							'class' => 'picker',
						),
						'options' => array(
							'label' => $champ->label,
						),
					));
					break;
				case 'nombre':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array(
							'type'  => 'number',
							'description' => $champ->description,
							'class' => 'other',
						),
						'options' => array('label' => $champ->label),
					));
					break;
				case 'fichier':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array(
							'type'  => 'file',
							'description' => $champ->description,
							'class' => 'other',
						),
						'options' => array('label' => $champ->label),
					));
					break;
				case 'url':
					$this->add(array(
						'name' => $champ->label,
						'attributes' => array(
							'type'  => 'url',
							'description' => $champ->description,
							'class' => 'other',
						),
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
					'class' => 'btn btn-primary',
				));
		$this->add($button);
	}
	
}
