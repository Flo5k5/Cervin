<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityRepository;

/**
 * Spécialisation de la classe Champ lorsque la champ correspondante est au format select
 * 
 * @ORM\Entity
 * @ORM\Table(name="mbo_champselect")
 * 
 * @property Collection\Entity\Select $select est la liste de select  
 * 
 */
class ChampSelect extends Champ
{

    /**
     * 
     * 
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Select", inversedBy="champs_select")
     **/
    protected $select;
	
	/**
	 * Magic getter to expose protected properties.
	 *
	 * @param string $property
	 * @return mixed
	 */
	public function __get($property)
	{
		return $this->$property;
	}

	/**
	 * Magic setter to save protected properties.
	 *
	 * @param string $property
	 * @param mixed $value
	 */
	public function __set($property, $value)
	{
		$this->$property = $value;
	}


}
