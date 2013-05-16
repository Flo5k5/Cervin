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
* @ORM\Entity(repositoryClass="Collection\Entity\ElementRepository")
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
        			$databd = new DataFichier($this, $champ);
        			// On stocke le fichier dans le dossier public/uploads/artefacts/'champ_id'/'datetime'/
        			if ($data[$index]['tmp_name'] != null) {
	        			$tmp = $data[$index]['tmp_name'];
	        			if($this instanceof Artefact){ 
	        			    $champ_dir = "/uploads/artefacts/" . (string)$champ->id;
                        }
                        elseif($this instanceof Media){
                            $champ_dir = "/uploads/medias/" . (string)$champ->id;
                        }
                        else {
                            throw new \Exception("Error Processing Request");
                        }
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

    public function deleteFile($element){
    	if($element->fichier !== null){
    		$dir = $_SERVER["DOCUMENT_ROOT"] . dirname($element->fichier);
    		$this->delTree( $dir );
    		return true;
    	}
    	return false;
    }
    
    /* Cr�dit : http://fr2.php.net/manual/fr/function.rmdir.php#92661 */
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

class ElementRepository extends EntityRepository
{

    public function getThisChamps($id = 2)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $query = $qb->select('d.id, dtx.texte, dd.date, df.fichier, df.format_fichier, dn.nombre, du.url, dta.textarea, c.label, c.format, c.description')
			        ->from('Collection\Entity\Data','d')
			        ->leftJoin('Collection\Entity\DataDate', 'dd', 'WITH', 'd.id = dd.id')
			        ->leftJoin('Collection\Entity\DataFichier', 'df', 'WITH', 'd.id = df.id')
			        ->leftJoin('Collection\Entity\DataNombre', 'dn', 'WITH', 'd.id = dn.id')
			        ->leftJoin('Collection\Entity\DataTexte', 'dtx', 'WITH', 'd.id = dtx.id')
			        ->leftJoin('Collection\Entity\DataUrl', 'du', 'WITH', 'd.id = du.id')
			        ->leftJoin('Collection\Entity\DataTextarea', 'dta', 'WITH', 'd.id = dta.id')
			        ->innerJoin('Collection\Entity\Champ', 'c', 'WITH', 'd.champ = c.id')
			        ->where('d.element = '.$id)
			        ;

        return $query->getQuery()->getResult();
    }

}
