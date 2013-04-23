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
		
		$titre = new ELement\Text('titre');
		$titre
			->setLabel('Titre')
			->setAttribute('description', 'Titre de l\'élément');
		$this->add($titre);
		
		$description = new ELement\Textarea('description');
		$description
			->setLabel('Description')
			->setAttributes(array(
					'description'  => 'Description générale de l\'élément',
					'rows'  => 4,
					'col' => 20
			));
		$this->add($description);
		
		foreach ($type_element->__get('champs') as $champ) {
			
			switch ($champ->__get('format')) {
				case 'texte':
					$this->add(array(
						'name' => $champ->__get('label'),
						'attributes' => array('type'  => 'text', 'description'  => $champ->__get('description')),
						'options' => array('label' => $champ->__get('label'))
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
