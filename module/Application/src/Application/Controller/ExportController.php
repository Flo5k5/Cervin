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

class ExportController extends AbstractActionController
{
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

    public function parcoursAction() {

    	$id = (int) $this->params('idParcours', null);
        if (null === $id) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }
        $Parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
        if ($Parcours === null) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }



        return $this->getResponse()->setContent(Json::encode());
    }
}