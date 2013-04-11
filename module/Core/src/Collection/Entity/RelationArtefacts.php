<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Une relation entre deux artefacts
*
* @ORM\Entity
* @ORM\Table(name="artefact_artefact")
* @property int $id
*/
class RelationArtefacts implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
    * @ORM\Id
    * @ORM\Column(type="integer");
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Artefact", inversedBy="artefacts_lies")
     * @ORM\JoinColumn(name="origine_id", referencedColumnName="id", nullable=false)
     **/
    protected $origine;
    
    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Artefact")
     * @ORM\JoinColumn(name="destination_id", referencedColumnName="id", nullable=false)
     **/
    protected $destination;
    
    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\SemantiqueArtefact")
     * @ORM\JoinColumn(name="semantique_id", referencedColumnName="id", nullable=false)
     **/
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
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;
        }
    	return $this->inputFilter;
    }
}
