<?php

namespace Parcours\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Un sous-parcours
*
* @ORM\Entity
* @ORM\Table(name="movingbo_sousParcours")
* @property int $id
* @property string $titre
*/
class SousParcours implements InputFilterAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\Parcours", inversedBy="sous_parcours")
     **/
    protected $parcours;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\Transition", mappedBy="sous_parcours")
     **/
    protected $transitions;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\Scene", mappedBy="sous_parcours")
     **/
    protected $scenes;
    
    /**
     * @ORM\OneToOne(targetEntity="Parcours\Entity\SceneRecommandee")
     **/
    protected $scene_depart;

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
