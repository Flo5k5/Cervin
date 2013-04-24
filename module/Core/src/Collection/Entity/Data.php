<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* La valeur d'un champ d'un �l�ment
*
* @ORM\Entity
* @ORM\Table(name="data")
* @property int $id
* @property date $date
* @property fichier $string
* @property nombre $float
* @property texte $string
* @property url $string
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
    * La valeur s'il s'agit d'une date, null sinon
    * @ORM\Column(type="datetime", nullable=true)
    */
    protected $date;
    
    /**
     * La valeur s'il s'agit d'un fichier, null sinon
     * @ORM\Column(type="date", length=200, nullable=true)
     */
    protected $fichier;
    
    /**
     * La valeur s'il s'agit d'un nombre, null sinon
     * @ORM\Column(type="float", nullable=true)
     */
    protected $nombre;
    
    /**
     * La valeur s'il s'agit d'un texte, null sinon
     * @ORM\Column(type="text", nullable=true)
     */
    protected $texte;
    
    /**
     * La valeur s'il s'agit d'une url, null sinon
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $url;
    
    /**
     * L'�l�ment auquel la donn�e se rapporte
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
    	$this->date = $data['date'];
    	$this->fichier = $data['fichier'];
    	$this->nombre = $data['nombre'];
    	$this->texte = $data['texte'];
    	$this->url = $data['url'];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {

    }
}
