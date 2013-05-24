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
use Doctrine\ORM\EntityRepository;

use Collection\Entity\Artefact;
use Collection\Entity\Media;

/**
* Un élément de la collection num�rique (artefact ou m�dia)
*
* @ORM\Entity
* @ORM\Table(name="mbo_element")
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
    * @ORM\Column(type="string", length=200)
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
    * Cette fonction est liée au formulaire ChampTypeElementForm
    * Elle prend en entrée les datas postés depuis ce formulaire
    *
    * @param array $data
    */
    public function populate($data = array())
    {
        $this->titre = $data['titre'];
        $this->description = $data['description'];
        $this->datas = new \Doctrine\Common\Collections\ArrayCollection();
        
        foreach ($this->type_element->champs as $champ) {
        	$index = 'champ_'.$champ->id;
        	switch ($champ->format) {
        		case 'texte':
        			$databd = new DataTexte($this, $champ);
        			if ($data[$index]) {
        				$databd->texte = $data[$index];
        			}
        			$this->datas->add($databd);
        			break;
        		case 'textarea':
        			$databd = new DataTextarea($this, $champ);
        			if ($data[$index]) {
        				$databd->textarea = $data[$index];
        			}
        			$this->datas->add($databd);
        			break;
        		case 'nombre':
        			$databd = new DataNombre($this, $champ);
        			if ($data[$index]) {
        				$databd->nombre = $data[$index];
        			}
        			$this->datas->add($databd);
        			break;
        		case 'url':
        			$databd = new DataUrl($this, $champ);
        			if ($data[$index]) {
        				$databd->url = $data[$index];
        			}
        			$this->datas->add($databd);
        			break;
        		case 'date':
        			$databd = new DataDate($this, $champ);
        			if ($data[$index] != null) {
        				$databd->date = new \DateTime($data[$index]);
        			}
        			$this->datas->add($databd);
        			break;
        		case 'fichier':
        			if ($data[$index]['tmp_name'] != null) {
        				$this->addFile(new DataFichier($this, $champ), $data[$index]['tmp_name'], $data[$index]['name'], $data[$index]['type']);
        			}
        			break;
        	}
        }
    }
    
    /**
     * Récupère le fichier uploadé pour l'insérer dans l'arborescence public/uploads
     * et ajoute le chemin vers ce fichier aux datas de l'élément
     */
    public function addFile($data, $tmpname ,$name, $format) {
    	// On stocke le fichier dans le dossier public/uploads/artefacts/'champ_id'/'datetime'/
    	// ou dans public/uploads/medias/'champ_id'/'datetime'/
    	if($this instanceof Artefact){
    		$champ_dir = "/uploads/artefacts/" . (string)$data->champ->id;
    	} elseif($this instanceof Media) {
    		$champ_dir = "/uploads/medias/" . (string)$data->champ->id;
    	} else {
    		throw new \Exception("Error Processing Request");
    	}
    	mkdir($_SERVER['DOCUMENT_ROOT'] . $champ_dir);
    	
    	$dest_dir = $champ_dir . "/" . date("Y-m-d-H-i-s");
    	mkdir($_SERVER['DOCUMENT_ROOT'] . $dest_dir);
    	
    	move_uploaded_file($tmpname, $_SERVER['DOCUMENT_ROOT'] . $dest_dir . "/" . $name);
    	$data->fichier = $dest_dir . "/" . $name;
    	$data->format_fichier = $format;
    	$this->datas->add($data);
    }
    
    public function updateFile($data, $tmpname ,$name, $format) {
    	$this->deleteFile($data);
    	$this->addFile($data, $tmpname ,$name, $format);
    }

	/**
	 * Supprime le fichier attaché à un DataFichier
	 */
    public function deleteFile($data){
    	if($data->fichier !== null){
    		$dir = $_SERVER["DOCUMENT_ROOT"] . dirname($data->fichier);
    		$this->delTree( $dir );
    		return true;
    	}
    	return false;
    }
    
    /* Crédit : http://fr2.php.net/manual/fr/function.rmdir.php#92661 */
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
    					$file->setRequired(true);
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
    					$inputFilter->add($factory->createInput(array(
    					'name' => 'champ_'.strval($champ->id),
    					'required' => false,
    					'validators' => array(
    					array(
    					'name' => 'regex',
    					'options'=>array(
    					'pattern' => '/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/',
    					'messages'=> array('regexNotMatch'=>'L\'entrée ne semble pas être une date valide'),
    					),
    					),
    					),
    					)));
    					break;
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
