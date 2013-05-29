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
 * Entité d'un artefact
 *
 * @ORM\Entity(repositoryClass="Collection\Entity\ArtefactRepository")
 * @ORM\Table(name="mbo_artefact")
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
	 * @ORM\JoinTable(name="mbo_artefact_media")
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

/**
 * Repository d'un artefact
 */
class ArtefactRepository extends EntityRepository
{

}
