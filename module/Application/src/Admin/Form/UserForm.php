<?php

namespace Admin\Form;

use Zend\Form\Form;
use InvalidArgumentException;

/**
 * Formulaire utilisé pour la création d'un utilisateur depuis l'administration
 *
 */
class UserForm extends Form
{
	public function __construct($name = null)
	{
		
		parent::__construct('user');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'id',
			'attributes' => array('type' => 'hidden')
			));

		$this->add(array(
			'name' => 'display_name',
			'attributes' => array('type' => 'text','placeholder'=>'Titre [max 200]'),
			'options' => array('label' => 'display_name')
			));
		
		$this->add(array(
			'name' => 'email',
			'attributes' => array('type'  => 'text','placeholder'=>'Description'),
			'options' => array('label' => 'email')
		));
		
		
		$this->add(array(
			'name' => 'username',
			'attributes' => array('type'  => 'text','placeholder'=>'Description'),
			'options' => array('label' => 'username')
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
