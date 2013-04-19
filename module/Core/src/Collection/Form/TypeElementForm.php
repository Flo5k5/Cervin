<?php

namespace Collection\Form;

use Zend\Form\Form;
use InvalidArgumentException;
use Collection\Entity\TypeElement;

class TypeElementForm extends Form
{
	public function __construct($name = null)
	{
		
		parent::__construct('typeelement');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'id',
			'attributes' => array('type' => 'hidden')
		));
		
		$this->add(array(
			'name' => 'nom',
			'attributes' => array('type' => 'text'),
			'options' => array('label' => 'Nom du type d\'élément')
		));
		
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Valider',
				'id' => 'submitbutton'
			),
		));
		
	}
	
}
