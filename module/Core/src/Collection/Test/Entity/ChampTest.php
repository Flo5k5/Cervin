<?php
namespace Collection;

use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\SchemaTool;

// $this->application instance of Zend\Mvc\Application
// $this->sm instance of Zend\ServiceManager\ServiceManager
// $this->em instance of Doctrine\ORM\EntityManager

class ChampTest extends \PHPUnit_Framework_TestCase
{
	protected $application;
    protected $sm;
	protected $em;
    protected $bootstrap;
	protected $emAlias;
	
    public function setUp()
    {
		$this
            ->setBootstrap(__DIR__ . '/../../../../../../tests/bootstrap.php')
            ->setEmAlias('doctrine.entitymanager.orm_default');
			
        $application = require $this->bootstrap;
        $this->application = $application;
        $this->sm = $application->getServiceManager();
        $this->em = $this->sm->get($this->emAlias);

        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadatas)) {
            $tool = new SchemaTool($this->em);
            //$tool->createSchema($metadatas);
        } else {
            throw new SchemaException(
                'No metadata classes to process'
            );
        }
    }

    public function tearDown()
    {
        unset($this->application);
        unset($this->sm);
        unset($this->em);
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
    
    public function testChampSaveEntity(){ 	
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

    protected function setBootstrap($bootstrap)
    {
        $this->bootstrap = $bootstrap;
        return $this;
    }
    
    protected function setEmAlias($emAlias)
    {
        $this->emAlias = $emAlias;
        return $this;
    }

    public function testServiceManagerInstance()
    {
        $this->assertInstanceOf(
            'Zend\ServiceManager\ServiceManager',
            $this->sm);
    }
	
    public function testEmInstance()
    {
        $this->assertInstanceOf(
            'Doctrine\ORM\EntityManager',
            $this->em);
    }
}
