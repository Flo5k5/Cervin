<?php

namespace AdminTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Album\Model\Album;
//use Album\Form\AlbumForm;
use Doctrine\ORM\EntityManager;
//use Album\Entity\Album;


use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;


use Zend\Mvc\Controller\Plugin\Url;
use BjyAuthorize\Provider\Role\Config;

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

		$postData = array('identity' => 'toto',
	        'credential' => 'toto123');

 $this->dispatch('http://zf2.localhost/user/login', 'POST', $postData);

		//$this->assertResponseStatusCode(200);
	   // $csrf = $this->_getLoginFormCSRF();
	 //   $this->resetResponse();
		

	   // $this->request->setMethod('POST');
	   // $this->request->setPost(array(
	   //     'identity' => 'toto',
	   //     'credential' => 'toto123',
	   // ));



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
