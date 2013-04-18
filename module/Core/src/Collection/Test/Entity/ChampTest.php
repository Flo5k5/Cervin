<?php
namespace Collection;

use TestsCervin\Doctrine;

class ChampTest extends Doctrine
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testChampInitialState()
    {
        $champ = new Entity\Champ(null, null, "texte");

        $this->assertNull($champ->id, '"id" should initially be null');
        $this->assertNull($champ->label, '"label" should initially be null');
        $this->assertNull($champ->description, '"description" should initially be null');
        $this->assertNull($champ->datas, '"datas" should initially be null');
        $this->assertNull($champ->type_element, '"type_element" should initially be null');
    }

    public function testChampSaveEntity()
    {
        $nom = 'Nom';
        $type = 'artefact';
        $typeElement = new Entity\TypeElement($nom, $type);

        $label = 'Label';
        $description = 'Description';
        $format = 'texte';

        $champ = new Entity\Champ($label, $typeElement, $format);
        $champ->description = $description;

        $this->em->persist($typeElement);
        $this->em->persist($champ);
        $this->em->flush();
    }
}
