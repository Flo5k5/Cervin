<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;


/**
 * Un média
 *
 * @ORM\Entity
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
			throw new InvalidArgumentException('Tentative de création d\'un média avec un type élément caractérisant un artefact => INTERDIT');
		}
		$this->titre = $titre;
		$this->type_element = $type_element;
		foreach ($type_element->__get('champs') as $champ) {
			$data = new Data($this, $champ);
			$this->datas->add($data);
		}
	}
	
}
