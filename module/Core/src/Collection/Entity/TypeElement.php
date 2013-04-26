<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Query;
/**
* Un type d'�l�ment de la collection (personne, image, mat�riel, logiciel, ...)
*
* @ORM\Entity(repositoryClass="Collection\Entity\TypeElementRepository")
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
     * L'ensemble des champs d�crivant cet artefact
     * @ORM\OneToMany(targetEntity="Collection\Entity\Champ", mappedBy="type_element", cascade={"remove"})
     **/
    protected $champs;
    
    /**
     * Constructeur
     **/
    public function __construct($nom = '', $type) {
    	if ($type != "artefact" && $type != "media") {
    		throw new InvalidArgumentException("Construction d'un objet TypeElement avec un attribut type diff�rent de 'artefact' ou 'media' => INTERDIT");
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
    	$this->nom = $data['nom'];
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
    			'name' => 'nom',
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
class TypeElementRepository extends EntityRepository
{





    public function getIdNameArray()
    {

        $query = $this->getEntityManager()->
        createQuery('SELECT e.id, e.nom FROM Collection\Entity\TypeElement e INDEX BY e.id WHERE e.type = \'media\'');

        $array = $query->getResult(Query::HYDRATE_RECORD); 
        $return = current($array);
    //    $return = array_combine($array['id'],['nom']);

        return $array ;

    }
}
