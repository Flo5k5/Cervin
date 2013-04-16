<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Une s�mantique possible des relations entre deux artefacts
*
* @ORM\Entity
* @ORM\Table(name="semantiqueartefact")
* @property int $id
* @property string $type_origine
* @property string $type_destination
* @property string $semantique
*/
class SemantiqueArtefact implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
    * @ORM\Id
    * @ORM\Column(type="integer");
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
     * La s�mantique d'une relation entre deux artefacts d�pend du type de ces artefacts
     * $type_origine contient la cha�ne d�crivant le type du premier artefact
     * @ORM\OneToOne(targetEntity="Collection\Entity\TypeElement")
     **/
    protected $type_origine;
    
    /**
     * $type_destination contient la cha�ne d�crivant le type du deuxi�me artefact
     * @ORM\OneToOne(targetEntity="Collection\Entity\TypeElement")
     */
    protected $type_destination;
    
    /**
    * @ORM\Column(type="string", length=200)
    */
    protected $semantique;
    
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
        $this->semantique = $data['semantique'];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
    	
    }
}
