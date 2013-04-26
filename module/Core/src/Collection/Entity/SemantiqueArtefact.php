<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Une sémantique possible des relations entre deux artefacts
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
     * La sémantique d'une relation entre deux artefacts dépend du type de ces artefacts
     * $type_origine contient la chaîne décrivant le type du premier artefact
     * @ORM\ManyToOne(targetEntity="Collection\Entity\TypeElement", cascade={"persist"})
     **/
    protected $type_origine;
    
    /**
     * $type_destination contient la chaîne décrivant le type du deuxième artefact
     * @ORM\ManyToOne(targetEntity="Collection\Entity\TypeElement", cascade={"persist"})
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

    public function getInputFilter($typeElementsArtefactArray = array())
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
        
            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(array('name' => 'Int')),
            )));
                //var_dump($typeElementsArtefactArray);
            $inputFilter->add($factory->createInput(array(
                'name'     => 'type_destination',
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => $typeElementsArtefactArray,
                            'messages' => array(
                                \Zend\Validator\InArray::NOT_IN_ARRAY => 'Please select your gender !'  
                            ),
                        ),
                    ),
                ),
            )));  
            $inputFilter->add($factory->createInput(array(
                'name'     => 'type_origine',
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => $typeElementsArtefactArray,
                            'messages' => array(
                                \Zend\Validator\InArray::NOT_IN_ARRAY => 'Please select your gender !'  
                            ),
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'semantique',
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
            
            $this->inputFilter = $inputFilter;
        }
    	return $this->inputFilter;
    }
}
