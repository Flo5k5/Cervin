<?php

namespace AdminTest\Controller;

use Zend\Http\Request;
use Zend\Http\Response;
use SamUser\Entity\User;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AdminControllerTest extends AbstractHttpControllerTestCase
{
	protected $traceError = true;


	protected $request;

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ .'/../../../../../../config/application.config.php'
        );

        $this->request    = new Request();
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

		$postData = array(
							'identity' => 'adminlogin',
	  						'credential' => 'toto123'
						);

 		$this->dispatch('/user/login', 'POST', $postData);
 		$this->assertMatchedRouteName('zfcuser/login');
		//$this->assertResponseStatusCode(200);
		$this->assertRedirectTo('/');
		
		//$this->dispatch('/user/login');
		//$this->assertNotXpathQueryContentContains('/html/body/div[2]/div/form/fieldset/ul/li', 'Authentication failed. Please try again.');
		
	   // $csrf = $this->_getLoginFormCSRF();
	 //   $this->resetResponse();
		

	   // $this->request->setMethod('POST');
	   // $this->request->setPost(array(
	   //     'identity' => 'toto',
	   //     'credential' => 'toto123',
	   // ));



		/*$this->dispatch('/admin/gestion-users');
		$this->assertResponseStatusCode(200);
		//$this->assertNotXpath( '//div[@id="errors"]' );
		//$this->assertRedirectTo('home');

		$this->assertModuleName('Admin');
		$this->assertControllerName('Admin');
		$this->assertControllerClass('AdminController');
		$this->assertMatchedRouteName('editusers');*/
	}



/*
	public function testSuccess()
    {
        $this->assertContains(4, array(1, 2, 3, 4));
    }
*/


}
