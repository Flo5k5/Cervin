<?php

namespace Parcours\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Un parcours
*
* @ORM\Entity
* @ORM\Table(name="mbo_parcours")
* @property int $id
* @property string $titre
* @property string $description
*/
class Parcours implements InputFilterAwareInterface
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
    * @ORM\Column(type="text")
    */
    protected $description;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\SousParcours", mappedBy="parcours", cascade={"persist", "remove"})
     **/
    protected $sous_parcours;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\Transition", mappedBy="parcours", cascade={"remove", "persist"})
     **/
    protected $transitions;
    
    public function addSousParcours($sous_parcours) {
    	$sous_parcours->parcours = $this;
    	if (!$this->sous_parcours->contains($sous_parcours)) {
    		$this->sous_parcours->add($sous_parcours);
    	}
    }
    
    public function addTransition($transition) {
    	$transition->parcours = $this;
    	if (!$this->transitions->contains($transition)) {
    		$this->transitions->add($transition);
    	}
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
        $this->id = $data['id'];
        $this->description = $data['description'];
        $this->titre = $data['titre'];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
             
            $inputFilter->add($factory->createInput(array(
                    'name' => 'id',
                    'required' => true,
                    'filters' => array(array('name' => 'Int')),
            )));
             
            $inputFilter->add($factory->createInput(array(
                    'name' => 'titre',
                    'required' => true,
                    'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                            array(
                                    'name' => 'StringLength',
                                    'options' => array(
                                            'encoding' => 'UTF-8',
                                            'min' => 1,
                                            'max' => 200,
                                    ),
                            ),
                    ),
            )));
             
            $inputFilter->add($factory->createInput(array(
                    'name' => 'description',
                    'required' => false,
                    'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                    ),
            )));
            $this->inputFilter = $inputFilter;
            
        }
        return $this->inputFilter;
    }
}
