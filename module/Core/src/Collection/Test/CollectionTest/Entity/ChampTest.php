<?php
namespace CollectionTest\Entity;

use Doctrine\ORM\EntityManager;
use Core\Collection\Entity\Champ;

use PHPUnit_Framework_TestCase;

class ChampTest extends PHPUnit_Framework_TestCase
{
    public function testChampInitialState()
    {
        $champ = new Champ();

        $this->assertNull($champ->id, '"id" should initially be null');
        $this->assertNull($champ->label, '"label" should initially be null');
        $this->assertNull($champ->description, '"description" should initially be null');
        $this->assertNull($champ->format, '"format" should initially be null');
        $this->assertNull($champ->datas, '"datas" should initially be null');
        $this->assertNull($champ->type_element, '"type_element" should initially be null');
    }
}
