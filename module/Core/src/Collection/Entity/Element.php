<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Un élément de la collection numérique (artefact ou média)
*
* @ORM\Entity
* @ORM\Table(name="element")
* @ORM\InheritanceType("SINGLE_TABLE")
* @ORM\DiscriminatorColumn(name="discr", type="string")
* @ORM\DiscriminatorMap({"Artefact" = "Artefact", 
*                        "Media" = "Media"})
* @property int $id
* @property string $titre
* @property string $description
* @property string $droits
*/
class Element implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
    * @ORM\Id
    * @ORM\Column(type="integer");
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @ORM\Column(type="string", length=200)
    */
    protected $titre;

    /**
    * @ORM\Column(type="text", nullable=true)
    */
    protected $description;
    
    /**
     * Type de l'élément
     * @ORM\ManyToOne(targetEntity="Collection\Entity\TypeElement")
     **/
    protected $type_element;
    
    /**
     * Valeurs des champs decrivant l'élément
     * @ORM\OneToMany(targetEntity="Collection\Entity\Data", mappedBy="element", cascade={"remove"}))
     **/
    protected $datas;
    
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
        $this->id = $data['id'];
        $this->titre = $data['titre'];
        $this->description = $data['description'];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
    	
    }
}
