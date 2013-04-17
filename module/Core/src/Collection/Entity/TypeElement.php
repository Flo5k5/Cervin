<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;

/**
* Un type d'élément de la collection (personne, image, matériel, logiciel, ...)
*
* @ORM\Entity
* @ORM\Table(name="typeelement")
* @property int $id
* @property string $nom
* @property string $type
*/
class TypeElement implements InputFilterAwareInterface
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
    protected $nom;
    
    /**
     * Type : 'artefact' ou 'media'
     * @ORM\Column(type="string", length=200)
     */
    protected $type;
    
    /**
     * L'ensemble des champs décrivant cet artefact
     * @ORM\OneToMany(targetEntity="Collection\Entity\Champ", mappedBy="type_element")
     **/
    protected $champs;
    
    /**
     * Constructeur
     **/
    public function __construct($nom, $type) {
    	if ($type != "artefact" && $type != "media") {
    		throw new InvalidArgumentException("Construction d'un objet TypeElement avec un attribut type différent de 'artefact' ou 'media' => INTERDIT");
    	}
    	$this->nom = $nom;
    	$this->type = $type;
    	$this->champs = array();
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
