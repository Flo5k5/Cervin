<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\WebService;

//use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;
use Zend\Json\Json;

class ExportClass
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	private function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Return a EntityManager
	 *
	 * @return Doctrine\ORM\EntityManager
	 */
	private function getEntityManager()
	{
		if ($this->em === null) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}

		return $this->em;
	}

	/**
	 * Affiche un parcours
	 *
	 * @param int  $id Id du parcours
	 * 
	 * @return array
	 */
    public function parcoursAction($id){

    	//$id = (int) $this->params('idParcours', null);
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