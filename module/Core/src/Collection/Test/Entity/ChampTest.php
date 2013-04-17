<?php
namespace Collection;

use Heartsentwined\Phpunit\Testcase\Doctrine as DoctrineTestcase;

class ChampTest extends DoctrineTestcase
{
	public function setUp()
    {
        // fluent interface available
        $this
            ->setBootstrap(__DIR__ . '/../../../../../../tests/bootstrap.php')
            ->setEmAlias('doctrine.entitymanager.orm_default')
            ->setTmpDir(__DIR__ . '/../../../../../../tests/tmp'); // optional: see use case above
        parent::setUp();
    }

    /*public function tearDown()
    {
        // your tearDown() operations
        parent::tearDown();
    }*/

    /*public function testFoo()
    {
        // $this->application instance of Zend\Mvc\Application
        // $this->sm instance of Zend\ServiceManager\ServiceManager
        // $this->em instance of Doctrine\ORM\EntityManager
        // $this->tmpDir = 'foo/tmp'
    }*/
	
    public function testChampInitialState()
    {
        $champ = new Entity\Champ();

        $this->assertNull($champ->id, '"id" should initially be null');
        $this->assertNull($champ->label, '"label" should initially be null');
        $this->assertNull($champ->description, '"description" should initially be null');
        $this->assertNull($champ->format, '"format" should initially be null');
        $this->assertNull($champ->datas, '"datas" should initially be null');
        $this->assertNull($champ->type_element, '"type_element" should initially be null');
    }
    
    public function testChampSaveEntity(){
    	
    	$type = new Entity\TypeElement();
    	$type->nom = 'Nom';
    	$type->type = 'Type';
    	
    	$champ = new Entity\Champ($type);
    	$champ->label = 'Label';
    	$champ->description = 'Description';
    	$champ->format = 'Format';
    	
    	$this->em->persist($type);
    	$this->em->persist($champ);
    	$this->em->flush();

    }
}
