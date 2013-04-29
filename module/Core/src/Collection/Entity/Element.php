<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Exception;

/**
* Un élément de la collection num�rique (artefact ou m�dia)
*
* @ORM\Entity
* @ORM\Table(name="element")
* @ORM\InheritanceType("SINGLE_TABLE")
* @ORM\DiscriminatorColumn(name="discr", type="string")
* @ORM\DiscriminatorMap({"Artefact" = "Artefact", 
*                        "Media" = "Media"})
* @property int $id
* @property string $titre
* @property string $description
* @property string $droits
*/
class Element implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
    * @ORM\Id
    * @ORM\Column(type="integer");
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @ORM\Column(type="string", length=200, unique=true)
    */
    protected $titre;

    /**
    * @ORM\Column(type="text", nullable=true)
    */
    protected $description;
    
    /**
     * Type de l'élément
     * @ORM\ManyToOne(targetEntity="Collection\Entity\TypeElement", inversedBy="elements")
     **/
    protected $type_element;
    
    /**
     * Valeurs des champs decrivant l'élément
     * @ORM\OneToMany(targetEntity="Collection\Entity\Data", mappedBy="element", cascade={"remove", "persist"}))
     **/
    protected $datas;

    /**
     * Type de l'élément
     * @ORM\OneToMany(targetEntity="Collection\Entity\RelationArtefacts", mappedBy="origine", cascade={"remove"})
     **/
    protected $relation_origine;
    
    /**
     * Type de l'élément
     * @ORM\OneToMany(targetEntity="Collection\Entity\RelationArtefacts", mappedBy="destination", cascade={"remove"})
     **/
    protected $relation_destination;
    
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
        $this->titre = $data['titre'];
        $this->description = $data['description'];
        $this->datas = new \Doctrine\Common\Collections\ArrayCollection();
        
        foreach ($this->type_element->champs as $champ) {
        	$databd = new Data($this, $champ);
        	$index = 'champ_'.$champ->id;
        	switch ($champ->format) {
        		case 'texte':
        		case 'textarea':
        		case 'nombre':
        		case 'url':
        			$databd->texte = $data[$index];
        			$this->datas->add($databd);
        			break;
        		case 'date':
        			if ($data[$index] != null) {
        				$databd->date = new \DateTime($data[$index]);
        			}
        			$this->datas->add($databd);
        			break;
        		case 'fichier':
        			// On stocke le fichier dans le dossier public/uploads/artefacts/'champ_id'/'datetime'/
        			if ($data[$index]['tmp_name'] != null) {
	        			$tmp = $data[$index]['tmp_name'];
	        			
	        			$champ_dir = "/uploads/artefacts/" . (string)$champ->id;
	        			mkdir($_SERVER['DOCUMENT_ROOT'] . $champ_dir);
	        			
	        			$dest_dir = $champ_dir . "/" . date("Y-m-d-H-i-s");
	        			mkdir($_SERVER['DOCUMENT_ROOT'] . $dest_dir);
	        			
	        			$name = $data[$index]['name'];
	        			
	        			move_uploaded_file($tmp, $_SERVER['DOCUMENT_ROOT'] . $dest_dir . "/" . $name);
	        			$databd->fichier = $dest_dir . "/" . $name;
	        			$databd->format_fichier = $data[$index]['type'];
        			}
        			$this->datas->add($databd);
        			break;
        	}
        }
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
    
    		foreach ($this->type_element->champs as $champ) {
	    		switch ($champ->format) {
	        		case 'texte':
	        			$inputFilter->add($factory->createInput(array(
        					'name' => 'champ_'.strval($champ->id),
        					'required' => false,
        					'filters' => array(
        						array('name' => 'StripTags'),
        						array('name' => 'StringTrim'),
	        				),
	        			)));
	        			break;
	        		case 'textarea':
	        			$inputFilter->add($factory->createInput(array(
        					'name' => 'champ_'.strval($champ->id),
        					'required' => false,
        					'filters' => array(
        						array('name' => 'StripTags'),
        						array('name' => 'StringTrim'),
	        				),
	        			)));
	        			break;
	        		case 'fichier':
	        			$file = new FileInput('champ_'.strval($champ->id));
	        			$file->setRequired(false);
	        			$file->getFilterChain()->attachByName(
	        				'filerenameupload',
	        				array(
	        					'target' => $_SERVER['DOCUMENT_ROOT']."/tmpuploads/",
	        					'use_upload_name' => true,
	        				)
	        			);
	        			$inputFilter->add($file);
	        			break;
	        		case 'date':
	        		case 'nombre':
	        		case 'url':
	        			$inputFilter->add($factory->createInput(array(
	        				'name' => 'champ_'.strval($champ->id),
	        				'required' => false
	        			)));
	        			break;
	        	}
       		}	
    		
    		$this->inputFilter = $inputFilter;
    	}
    	
    	return $this->inputFilter;
    }

}
