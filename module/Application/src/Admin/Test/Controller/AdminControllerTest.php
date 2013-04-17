<?php

namespace AdminTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Album\Model\Album;
//use Album\Form\AlbumForm;
use Doctrine\ORM\EntityManager;
//use Album\Entity\Album;

use Zend\Mvc\Controller\Plugin\Url;
use BjyAuthorize\Provider\Role\Config;

class AdminControllerTest extends AbstractHttpControllerTestCase
{
	protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ .'/../../../../../../config/application.config.php'
        );
        parent::setUp();
    }
	
	/*public function setUp()
	{
		$di = Bootstrap::getDi();

		$this->controller = $di->newInstance('Album\Controller\AlbumController');

		$this->request    = new Request();
		$this->routeMatch = new RouteMatch(array('controller' => 'album'));
		$this->event      = new MvcEvent();
		$this->event->setRouteMatch($this->routeMatch);
		$this->controller->setEvent($this->event);

		$this->controller->setServiceLocator(Bootstrap::getServiceManager());
	}*/




	
	public function testEditusersActionCanBeAccessed()
	{


$this->dispatch('/zfcuser/login');

		$lien = 'http://zf2.localhost/user/login' ;// $this->url()->fromRoute("zfcuser/login");
		$postfields = array(
			'identity' => 'toto',
			'credential' => 'toto123'
		);

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $lien);
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

		$return = curl_exec($curl);
		curl_close($curl);



		if (!preg_match('#Hello, Toto#i', $return))
		{

			 $this->assertTrue(true);
		}
		else
		{
			 $this->assertTrue(FALSE);
		}



		$this->dispatch('/admin/gestion-users');
		$this->assertResponseStatusCode(200);

		$this->assertModuleName('Admin');
		$this->assertControllerName('Admin\Controller\Admin');
		$this->assertControllerClass('AdminController');
		$this->assertMatchedRouteName('editusers');
	}



/*
	public function testSuccess()
    {
        $this->assertContains(4, array(1, 2, 3, 4));
    }
*/


}
