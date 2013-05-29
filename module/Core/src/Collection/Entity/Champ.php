<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityRepository;

/**
* Entité d'un champ d'un type d'élément
*
* @ORM\Entity
* @ORM\Table(name="mbo_champ")
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
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $description;
    
    /**
     * Format du champ (texte, date, nombre, ...)
     * @ORM\Column(type="string", length=200)
     */
    protected $format;
    
    /**
     * Un champ a plusieurs valeurs (une pour chaque instance d'élément qu'il décrit)
     * @ORM\OneToMany(targetEntity="Collection\Entity\Data", mappedBy="champ", cascade={"remove"}))
     **/
    protected $datas;
    
    /**
     * Le type d'élément que décrit ce champ
     * @ORM\ManyToOne(targetEntity="Collection\Entity\TypeElement", inversedBy="champs")
     **/
    protected $type_element;

    /**
     * Booléen qui décrit si le champ est validé ou brouillon
     * @ORM\Column(type="boolean")
     **/
    protected $valide = false;
    
    /**
     * Constructeur
     **/
    public function __construct($label = '', $type_element = null, $format = 'texte') {
    	$this->label = $label;
    	$this->type_element = $type_element;
    	if ($format != "texte" 
    			&& $format != "textarea"
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
    	$this->label = $data['label'];
    	$this->description = $data['description'];
    	$this->format = $data['format'];
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
    			'name' => 'label',
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

    public function deleteFiles(){
    	if($this->format === 'fichier'){
    		$dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
    		 
    		if( $this->type_element->type === 'media' ){
    			$dir .= 'medias/';
    		} else if( $this->type_element->type === 'artefact' ) {
    			$dir .= 'artefacts/';
    		}
    		 
    		$dir .= (string)$this->id . '/';
    
    		$this->delTree($dir);
    		return true;
    	}
    	return false;
    }
    
    /**
     * Crédit : http://fr2.php.net/manual/fr/function.rmdir.php#92661
     */
    private function delTree($dir) {
    	if(is_dir($dir)){
    		$files = glob( $dir . '*', GLOB_MARK );
    		foreach( $files as $file ){
    			$file = str_replace('\\', '/', $file);
    			if( substr( $file, -1 ) == '/' ) {
    				$this->delTree( $file );
    			} else {
    				if( is_file($file) ){
    					chown( $file, 666 );
    					chmod( $file, 0666 );
    					unlink( $file );
    				}
    			}
    		}
    
    		rmdir( $dir );
    		return true;
    	}
    	return false;
    }
    
}
