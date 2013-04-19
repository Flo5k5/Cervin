<?php

namespace Collection\Form;

use Zend\Form\Form;
use InvalidArgumentException;
use Collection\Entity\TypeElement;

class ChampForm extends Form
{
	public function __construct($name = null)
	{
		if (!$type_element instanceof TypeElement) {
			throw new InvalidArgumentException('Construction d\'un formulaire TypeElementForm avec un param�tre qui n\'est pas de type TypeElement');
		}
		parent::__construct('typeelement');
		$this->setAttribute('method', 'post');

		$this->add(array(
			'name' => 'id',
			'attributes' => array('type'  => 'hidden')
		));
		
		$this->add(array(
			'name' => 'label',
			'attributes' => array('type'  => 'text'),
			'options' => array('label' => 'Label')
		));
		
		$this->add(array(
				'name' => 'description',
				'attributes' => array('type'  => 'textarea'),
				'options' => array('label' => 'Description')
		));
		
		$this->add(array(
            'type' => 'select',
            'name' => 'format',
            'options' => array(
                'label' => 'Format',
                'value_options' => array(
                    'text' => 'Texte',
                    'textarea' => 'Zone de texte',
                    'date' => 'Date',
                    'nombre' => 'Nombre',
                    'fichier' => 'Fichier',
                    'url' => 'URL'
                ),
            ),
            'attributes' => array(
                'value' => 'text' //set selected to 'text'
            )
        ));
			
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
