<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;

/**
* Une personne
*
* @ORM\Entity
* @property date $naissance
* @property date $mort
* @property string $nationnalite
*/
class ArtefactPersonne extends Artefact
{

    /**
    * @ORM\Column(type="date")
    */
    protected $naissance;
    
        /**
    * @ORM\Column(type="date")
    */
    protected $mort;
    
    /**
    * @ORM\Column(type="string", length=100)
    */
    protected $nationnalite;
    
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
