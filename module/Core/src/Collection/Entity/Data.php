<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Entité de la valeur d'un champ d'un élément
*
* @ORM\Entity
* @ORM\Table(name="mbo_data")
* @ORM\InheritanceType("JOINED")
* @ORM\DiscriminatorColumn(name="discr", type="string")
* @ORM\DiscriminatorMap({"DataDate" = "DataDate", 
*                        "DataFichier" = "DataFichier", 
*                        "DataNombre" = "DataNombre", 
*                        "DataTexte" = "DataTexte", 
*                        "DataUrl" = "DataUrl", 
*                        "DataTextarea" = "DataTextarea"})
*/
class Data implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
    * @ORM\Id
    * @ORM\Column(type="integer");
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
     * L'élément auquel la donnée se rapporte
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Element", inversedBy="datas")
     **/
    protected $element;
    
    /**
     * Le champ auquel la donn�e se rapporte
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Champ", inversedBy="datas")
     **/
    protected $champ;
    
    /**
     * Constructeur
     **/
    public function __construct($element, $champ) {
    	$this->element = $element;
    	$this->champ = $champ;
    }
    
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

    /**
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
