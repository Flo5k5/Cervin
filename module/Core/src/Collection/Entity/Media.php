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
 * Entité d'un média
 *
 * @ORM\Entity(repositoryClass="Collection\Entity\ArtefactRepository")
 * @ORM\Table(name="mbo_media")
 */
class Media extends Element
{
	protected $inputFilter;

	/**
	 * Artefact(s) lié(s) au media
	 * 
	 * @ORM\ManyToMany(targetEntity="Collection\Entity\Artefact", mappedBy="medias")
	 * @ORM\JoinTable(name="mbo_artefact_media")
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

	/**
	 * Constructeur
	 * 
	 * @param string $titre
	 * @param Collection\Entity\TypeElement $type_element
	 * @throws InvalidArgumentException
	 */
	public function __construct($titre, $type_element) {
		if ($type_element->__get('type') != 'media') {
			throw new InvalidArgumentException('Tentative de création d\'un média avec un type élément caractérisant un artefact => INTERDIT');
		}
		$this->titre = $titre;
		$this->type_element = $type_element;
	}
	
}

/**
 * Repository d'un media
 */
class MediaRepository extends EntityRepository
{

}
