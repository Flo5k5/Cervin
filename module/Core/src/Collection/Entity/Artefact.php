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
 * Un artefact
 *
 * @ORM\Entity(repositoryClass="Collection\Entity\ArtefactRepository")
 * @ORM\Table(name="movingbo_artefact")
 * @property int $id
 */
class Artefact extends Element
{
	protected $inputFilter;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * Médias liés à l'artefact
	 * @ORM\ManyToMany(targetEntity="Collection\Entity\Media", inversedBy="artefacts")
	 * @ORM\JoinTable(name="movingbo_artefact_media")
	 **/
	protected $medias;

	/**
	 * Lien vers les artefacts li�s
	 * @ORM\OneToMany(targetEntity="Collection\Entity\RelationArtefacts", mappedBy="origine")
	 **/
	protected $relations_artefacts;

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
	 * Constructeur
	 **/
	public function __construct($titre = null, $type_element) {
		if ($type_element->__get('type') != 'artefact') {
			throw new InvalidArgumentException('Tentative de cr�ation d\'un artefact avec un type �l�ment caract�risant un m�dia => INTERDIT');
		}
		$this->titre = $titre;
		$this->type_element = $type_element;
	}

}

class ArtefactRepository extends EntityRepository
{

    public function getThisChamps($id = 2)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        //$query = $qb->select('c.label, c.format, c.description, d.id, d.date, d.fichier, d.nombre, d.texte, d.textarea, d.url, d.format_fichier, c.id')
        /*$query = $qb->select('c.label, c.format, c.description, c.id, ed.id AS idData, cd.datatexte, cd.datadate')
        		->from('Collection\Entity\Champ','c')
        		->leftJoin('c.type_element', 'te')
        		->leftJoin('te.elements', 'e')

                ->where('e.id = '.$id)
        		->leftJoin('e.datas', 'ed')

                ->leftJoin('c.datas', 'cd')
               // ->leftJoin('d.element', 'de')
                ->andWhere('((cd.id = ed.id) OR (ed IS NULL))')
              ;*/

               $query = $qb->select('c.label,c.description,c.format,d')

               ->from('Collection\Entity\Champ','c')



               ->innerJoin('c.datas','d')
               ->innerJoin('d.element','de')

                ->andWhere('de.id = '.$id.'')





               ;


        return $query->getQuery()->execute();
    }
    
}
