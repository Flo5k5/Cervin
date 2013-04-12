<?php

namespace Parcours\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Une transition
*
* @ORM\Entity
* @ORM\Table(name="transition")
* @ORM\InheritanceType("SINGLE_TABLE")
* @ORM\DiscriminatorColumn(name="discr", type="string")
* @ORM\DiscriminatorMap({"TransitionRecommandee" = "TransitionRecommandee",
 *                      "TransitionSecondaire" = "TransitionSecondaire",
 *                      "TransitionInterParcours" = "TransitionInterParcours"})
* @property int $id
* @property string $narration
*/
class Transition implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
    * @ORM\Id
    * @ORM\Column(type="integer");
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @ORM\Column(type="text")
    */
    protected $narration;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\SemantiqueTransition")
     * @ORM\JoinColumn(name="semantique_id", referencedColumnName="id", nullable=false)
     **/
    protected $semantique;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\Parcours", inversedBy="transitions")
     **/
    protected $parcours;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\SousParcours", inversedBy="transitions")
     **/
    protected $sous_parcours;
    
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
