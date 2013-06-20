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
			'attributes' => array('type' => 'text','placeholder'=>'Nom / Prénom'),
			'options' => array('label' => 'Nom / prénom')
		));
		
		$this->add(array(
			'name' => 'email',
			'attributes' => array('type'  => 'text','placeholder'=>'Email'),
			'options' => array('label' => 'Email')
		));
		
		$this->add(array(
			'name' => 'username',
			'attributes' => array('type'  => 'text','placeholder'=>'Login'),
			'options' => array('label' => 'Login')
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
