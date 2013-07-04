<?php

namespace Collection\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use InvalidArgumentException;
use Collection\Entity\TypeElement;
use Doctrine\ORM\EntityManager;
/**
 * Formulaire utilisé pour la création d'un nouvel élément de la collection
 *
 */
class ChampTypeElementForm extends Form
{
	public function __construct(EntityManager $em, $type_element, $name = null)
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
				'class' => 'span12'
			));
		$this->add($hidden);
		
		$titre = new Element\Text();
		$titre->setName('titre')
			->setLabel('Titre')
			->setAttributes(array(
				'description' => 'Le titre de l\'élément',
				'class' => 'span12'
			));
		$this->add($titre);
		
		$description = new Element\Textarea();
		$description->setName('description')
			->setLabel('Description')
			->setAttributes(array(
				'class' => 'wysihtml5-textarea input-block-level',
				'style' => 'height: 300px',
				'placeholder' => 'Entrer la description générale de l\'élément',
		));
		$this->add($description);
		
		foreach ($type_element->champs as $champ) {
			$name = 'champ_'.strval($champ->id);
			switch ($champ->format) {
				case 'select':

					 $this->add(array(
					            'name' => $name,
					            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
					            'options' => array(
					                'label' => $champ->label,
					                'empty_option'    => '',
					                'object_manager' => $em,
					                'target_class' => 'Collection\Entity\SelectOption',
					                'property' => 'text',
					                'find_method'    => array(
						                'name'   => 'findBy',
						                'params' => array(
						                    'criteria' => array('select' => $champ->select),
						                    'orderBy'  => array('text' => 'ASC'),
						                ),
						            ),
					            ),
					            'attributes' => array(
					                'class' => 'span12 select'
					            )
					        ));
 					break;
				case 'texte':
					$text = new Element\Text();
					$text->setName($name)
						->setLabel($champ->label)
						->setAttributes(array(
							'description' => $champ->description,
							'class' => 'span12'
						));
					$this->add($text);
					break;
				case 'textarea':
					$textarea = new Element\Textarea();
					$textarea->setName($name)
						->setLabel($champ->label)
						->setAttributes(array(
							'description' => $champ->description,
							'class' => 'span12',
							'rows' => '6'
						));
					$this->add($textarea);
					break;
				case 'date':
					$date = new Element\Text();
					$date->setName($name)
						->setLabel($champ->label)
						->setAttributes(array(
							'type'  => 'text',
							'description' => $champ->description,
							'class' => 'datepicker span12',
							'besoin_format' => true
						))
						->setOptions(array(
							'format' => 'Y-m-d'
						));
					$this->add($date);
					
					$select = new Element\Select();
					$select->setName('format'.$name)
							->setAttributes(array(
							'class' => 'format_date span12',
							'data-input-name' => $name,
							'type'  => 'hidden'
					));
					$select->setValueOptions(array(
							'0' => 'Jour',
							'1' => 'Mois',
							'2' => 'Année',
					));
					$this->add($select);
					break;
				case 'nombre':
					$number = new Element\Number();
					$number->setName($name)
						->setLabel($champ->label)
						->setAttributes(array(
							'description' => $champ->description,
							'class' => 'span12'
						));
					$this->add($number);
					break;
				case 'fichier':
					$file = new Element\File();
					$file->setName($name)
						->setLabel($champ->label)
						->setAttributes(array(
							'description' => $champ->description,
							'title' => 'Parcourir'
					));
					$this->add($file);
					break;
				case 'url':
					$url = new Element\Url();
					$url->setName($name)
						->setLabel($champ->label)
						->setAttributes(array(
							'description' => $champ->description,
							'class' => 'span12'
						));
					$this->add($url);
					break;
				case 'geoposition':
					$geopos = new Element\Text();
					$geopos->setName($name)
					->setLabel($champ->label)
					->setAttributes(array(
							'type'  => 'text',
							'description' => $champ->description,
							'class' => 'gmaps span11'
					));
					$this->add($geopos);
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
