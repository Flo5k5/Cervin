<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Zend\Soap\Server;
use Zend\Soap\AutoDiscover;

class ExportController extends AbstractActionController
{
	private $_options;
	//private $serverUrl = strtolower(dirname($_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'];
	 //
    private $_URI      = '/export';
    private $_WSDL_URI = '/export?wsdl';
    //private $_WSDL_URI = $serverUrl.'/export?wsdl';

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Return a EntityManager
	 *
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		if ($this->em === null) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}

		return $this->em;
	}

    public function indexAction() {

        if (isset($_GET['wsdl'])) {
            $this->handleWSDL();
        } else {
            $this->handleSOAP();
        }

        return $this->getResponse();
    }

    private function handleWSDL() {
        $serverUrl    = strtolower(dirname($_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'];
        $autodiscover = new AutoDiscover();

        $autodiscover->setClass('Application\WebService\ExportClass')
                     ->setUri($serverUrl.$this->_URI);

        $autodiscover->handle();

        /*
		$serverUrl = 'http://time-tracker.com/application/soap';
        $soapAutoDiscover = new AutoDiscover();
	    $soapAutoDiscover->setBindingStyle(array('style' => 'document'));
	    $soapAutoDiscover->setOperationBodyStyle(array('use' => 'literal'));
	    $soapAutoDiscover->setClass('\Application\Service\Tracker');
	    $soapAutoDiscover->setUri($serverUrl);
	    $wsdl = $soapAutoDiscover->generate();
	    $wsdl = $wsdl->toDomDocument();
	    //so this is:
	    header("Content-Type: text/xml");
	    echo $wsdl->saveXML();
	    exit;*/
    }

    private function handleSOAP() {
    	$serverUrl = strtolower(dirname($_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'];
        $soap      = new Server($serverUrl.$this->_WSDL_URI);

        $soap->setClass('Application\WebService\ExportClass');

        $soap->handle();
    }
    
}