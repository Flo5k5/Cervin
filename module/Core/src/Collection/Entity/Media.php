<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityRepository;

use Collection\Entity\Element;

/**
 * Un m�dia
 *
 * @ORM\Entity(repositoryClass="Collection\Entity\ArtefactRepository")
 * @ORM\Table(name="media")
 * @property int $id
 */
class Media extends Element
{
	protected $inputFilter;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToMany(targetEntity="Collection\Entity\Artefact", mappedBy="medias")
	 **/
	protected $artefacts;


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

	public function __construct($titre, $type_element) {
		if ($type_element->__get('type') != 'media') {
			throw new InvalidArgumentException('Tentative de cr�ation d\'un m�dia avec un type �l�ment caract�risant un artefact => INTERDIT');
		}
		$this->titre = $titre;
		$this->type_element = $type_element;
	}
	
}

class MediaRepository extends EntityRepository
{

    public function getThisChamps($id = 2)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $query = $qb->select('d')
                    ->from('Collection\Entity\Data','d')
                    ;
        
        /*$query = $qb->select('c.label, c.format, c.description, d.id, d.date, d.fichier, d.nombre, d.texte, d.textarea, d.url, d.format_fichier, c.id')
        	        ->from('Collection\Entity\Champ','c')
        	        ->leftJoin('c.type_element', 'te')
        	        ->leftJoin('te.elements', 'e')
                    ->where('e.id = '.$id)
                    ->leftJoin('c.datas', 'd')
                    ->leftJoin('d.element', 'de')
                    ->andWhere('((de.id = e.id) OR (d IS NULL))');*/

        return $query->getQuery()->execute();
    }
    
}
