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
		
		$hidden = new Element\Hidden();
		$hidden->setName('id')
			->setAttributes(array(
				'type'  => 'hidden',
				'class' => 'span11'
			));
		$this->add($hidden);
		
		$titre = new Element\Text();
		$titre->setName('titre')
			->setLabel('Titre')
			->setAttributes(array(
					'description' => 'Le titre de l\'élément',
					'class' => 'span11'
			));
		$this->add($titre);
		
		$description = new Element\Textarea();
		$description->setName('description')
		->setLabel('Description')
		->setAttributes(array(
				'description' => 'La description générale de l\'élément',
				'class' => 'wysihtml5-textarea input-block-level',
				'style' => 'height: 300px',
				'placeholder' => 'Description...',
				'id' => 'description'
		));
		$this->add($description);
		
		foreach ($type_element->champs as $champ) {
			switch ($champ->format) {
				case 'texte':
					$text = new Element\Text();
					$text->setName($champ->id)
						->setLabel($champ->label)
						->setAttributes(array(
							'description' => $champ->description,
							'class' => 'span11'
						));
					$this->add($text);
					break;
				case 'textarea':
					$textarea = new Element\Textarea();
					$textarea->setName($champ->id)
						->setLabel($champ->label)
						->setAttributes(array(
							'description' => $champ->description,
							'class' => 'span11'
						));
					$this->add($textarea);
					break;
				case 'date':
					$date = new Element\Date();
					$date->setName($champ->id)
						->setLabel($champ->label)
						->setAttributes(array(
							'type'  => 'date',
							'description' => $champ->description,
							'class' => 'picker span11'
						))
						->setOptions(array(
								'format' => 'd-m-Y'
						));
					$this->add($date);
					break;
				case 'nombre':
					$number = new Element\Number();
					$number->setName($champ->id)
						->setLabel($champ->label)
						->setAttributes(array(
							'description' => $champ->description,
							'class' => 'span11'
						));
					$this->add($number);
					break;
				case 'fichier':
					$file = new Element\File('fichier' . $champ->id);
					$file->setName($champ->id)
							->setAttributes(array(
								'type'  => 'file',
								'description' => $champ->description,
							))
							->setOptions(array('label' => $champ->label));
					$this->add($file);
					break;
					/*
					$this->add(array(
						'name' => $champ->id,
						'attributes' => array(
							'type'  => 'file',
							'description' => $champ->description,
							'class' => 'span11'
						),
						'options' => array('label' => $champ->label),
					));
					break;
					//*/
				case 'url':
					$url = new Element\Url();
					$url->setName($champ->id)
						->setLabel($champ->label)
						->setAttributes(array(
							'description' => $champ->description,
							'class' => 'span11'
						));
					$this->add($url);
					break;
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
