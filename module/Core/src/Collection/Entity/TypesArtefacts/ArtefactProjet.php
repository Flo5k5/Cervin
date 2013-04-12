<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;

/**
* Un projet
*
* @ORM\Entity
* @property string $acteurs
* @property date $debut
* @property date $fin
*/
class ArtefactProjet extends Artefact
{

    /**
    * @ORM\Column(type="string", length=200)
    */
    protected $acteurs;
    
    /**
    * @ORM\Column(type="date")
    */
    protected $debut;
    
        /**
    * @ORM\Column(type="date")
    */
    protected $fin;
    
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

    /**
    * Convert the object to an array.
    *
    * @return array
    */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /*
    * Populate from an array.
    *
    * @param array $data
    */
    public function populate($data = array())
    {
    	
    }

     public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
    	
    }
}
