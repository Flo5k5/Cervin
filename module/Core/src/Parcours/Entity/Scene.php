<?php

namespace Parcours\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Une scène
*
* @ORM\Entity
* @ORM\Table(name="scene")
* @ORM\InheritanceType("SINGLE_TABLE")
* @ORM\DiscriminatorColumn(name="discr", type="string")
* @ORM\DiscriminatorMap({"SceneRecommandee" = "SceneRecommandee",
 *                      "SceneSecondaire" = "SceneSecondaire"})
* @property int $id
* @property string $titre
* @property string $narration
*/
class Scene implements InputFilterAwareInterface
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
    protected $narration;
    
    /**
     * @ORM\ManyToMany(targetEntity="Collection\Entity\Artefact")
     * @ORM\JoinColumn(name="artefact_id", referencedColumnName="id", nullable=false)
     **/
    protected $artefacts;
    
    /**
     * @ORM\ManyToMany(targetEntity="Collection\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=false)
     **/
    protected $medias;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\SousParcours", inversedBy="scenes")
     * @ORM\JoinColumn(name="sous_parcours_id", referencedColumnName="id", nullable=false)
     **/
    protected $sous_parcours;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\TransitionInterParcours", mappedBy="scene_origine")
     **/
    protected $transitions_inter_parcours;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\TransitionSecondaire", mappedBy="scene_origine")
     **/
    protected $transitions_secondaires;
    
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
