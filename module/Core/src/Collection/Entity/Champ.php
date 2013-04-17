<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;

/**
* Un champ d'un type d'élément
*
* @ORM\Entity
* @ORM\Table(name="champ")
* @property int $id
* @property string $label
* @property string $description
*/
class Champ implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
    * @ORM\Id
    * @ORM\Column(type="integer");
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
     * Nom du champ
     * @ORM\Column(type="string", length=200)
     */
    protected $label;
    
    /**
     * Description du champ
     * @ORM\Column(type="string", length=200)
     */
    protected $description;
    
    /**
     * Format du champ (texte, date, nombre, ...)
     * @ORM\Column(type="string", length=200)
     */
    protected $format;
    
    /**
     * Un champ a plusieurs valeurs (une pour chaque instance d'élément qu'il décrit)
     * @ORM\OneToMany(targetEntity="Collection\Entity\Data", mappedBy="champ")
     **/
    protected $datas;
    
    /**
     * Le type d'élément que décrit ce champ
     * @ORM\ManyToOne(targetEntity="Collection\Entity\TypeElement", inversedBy="champs")
     **/
    protected $type_element;
    
    /**
     * Constructeur
     **/
    public function __construct($label, $type_element, $format) {
    	$this->label = $label;
    	$this->type_element = $type_element;
    	if ($format != "texte" 
    			&& $format != "date"
    			&& $format != "fichier"
    			&& $format != "nombre"
    			&& $format != "url") {
    		throw new InvalidArgumentException("Construction d'un objet Champ avec un format interdit");
    	}
    	$this->format = $format;
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
