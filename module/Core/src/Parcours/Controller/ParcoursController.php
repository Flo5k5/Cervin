<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Parcours\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Parcours\Entity\Parcours;
use Parcours\Form\ParcoursForm;
use Parcours\Entity\TransitionRecommandee;
use Zend\Json\Json;

class ParcoursController extends AbstractActionController
{

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * Initialisation de l'Entity Manager
	 *
	 * @param Doctrine\ORM\EntityManager
	 * @return void
	 */
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * Retourne l'Entity Manager
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

    public function indexAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
    	$params = null;

    	if ($this->getRequest()->isXmlHttpRequest()) {
    		$params = $this->params()->fromPost();
    	}
    	
    	if(!isset($params["iSortCol_0"])){
    		$params["iSortCol_0"] = '0';
    	}

    	if(!isset($params["sSortDir_0"])){
    		$params["sSortDir_0"] = 'ASC';
    	}
    	
    	$entityManager = $this->getEntityManager()
    					      ->getRepository('Parcours\Entity\Parcours');
 
    	$dataTable = new \Parcours\Model\ParcoursDataTable($params);
    	$dataTable->setEntityManager($entityManager);
    
    	$dataTable->setConfiguration(array(
    		'titre',
	        'description'
    	));
    
    	$aaData = array();
    	
    	$paginator = null;
    	
    	if(isset($params["conditions"])){
    		$conditions = json_decode($params["conditions"], true);
    		$paginator = $dataTable->getPaginator($conditions);
    	} else {
    		$paginator = $dataTable->getPaginator();
    	}
    		
    	foreach ($paginator as $parcours) {
    		
    		$titre = '';
    		
			$titre = '<a class="href-type-element" href="'
							.$this->url()->fromRoute('parcours/voir', array('id' => $parcours->id)).'">'
							.$escapeHtml($parcours->titre).'
						</a>';
    		
			//$titre = $parcours->titre;
    		
    		
    		$aaData[] = array(
    				$titre,
    				$dataTable->truncate($parcours->description, 250, ' ...', false, true)
    		);
    	}
    	
    	$dataTable->setAaData($aaData);
    
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		return $this->getResponse()->setContent($dataTable->findAll());
    	} else {
    		return new ViewModel();
    	}
    }

    public function ajouterAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
        $form = new ParcoursForm();
        $Parcours = new Parcours();
        $form->bind($Parcours);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($Parcours->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEntityManager()->persist($Parcours);
                $this->getEntityManager()->flush();
                $this->flashMessenger()->addSuccessMessage(sprintf('La Parcours ["%1$s"] a bien été créé.', $escapeHtml($Parcours->titre)));
                return $this->redirect()->toRoute('parcours/voir', array ('id' => $Parcours->id));
            }
        }
        return new ViewModel(array('form'=>$form));
    }

    public function voirAction()
    {


        $id = (int) $this->params('id', null);
        if (null === $id) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }

        $Parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
        if ($Parcours === null) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }
        $SemantiqueTransitions = $this->getEntityManager()
                            ->getRepository('Parcours\Entity\SemantiqueTransition')
                            ->findBy(array(), array('semantique'=>'asc'));

        return new ViewModel(array('Parcours'=>$Parcours,'SemantiqueTransitions'=>$SemantiqueTransitions));
    }

    public function modifierAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) 
        {
            $id = (int) $this->params('id', null);
            $Parcours = $this->getEntityManager()
                                        ->getRepository('Parcours\Entity\Parcours')
                                        ->findOneBy(array('id'=>$id));
            if ($Parcours === null || $id === null) {
                $this->getResponse()->setStatusCode(404);
                return;
            }
            $request = $this->params()->fromPost();
            switch ($request['name']) {
                case 'titre':
                    $Parcours->titre = $request['value'];
                    $this->getEntityManager()->flush();
                    break;
                    
                case 'description':
                    $Parcours->description = $request['value'];
                    $this->getEntityManager()->flush();
                    break;
            
                default:
                    $this->getResponse()->setStatusCode(404);
                    break;
            }
            return $this->getResponse()->setContent(Json::encode(true));
        
        } else {
            $this->getResponse()->setStatusCode(404);
        }
    }
    /**  
    * Modifier la semantique ou la narration d'une transition 
    *    
    **/ 
        public function modifierTransitionAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) 
        {
            $id = (int) $this->params('id', null);
            $TransitionRecommandee = $this->getEntityManager()
                                        ->getRepository('Parcours\Entity\TransitionRecommandee')
                                        ->findOneBy(array('id'=>$id));
            if ($TransitionRecommandee === null || $id === null) {
                $this->getResponse()->setStatusCode(404);
                return;
            }
            $request = $this->params()->fromPost();
            switch ($request['name']) {
                case 'semantique':
                    $SemantiqueTransition = $this->getEntityManager()
                                        ->getRepository('Parcours\Entity\SemantiqueTransition')
                                        ->findOneBy(array('id'=>$request['value']));
                    $TransitionRecommandee->semantique = $SemantiqueTransition;
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(array('return'=>$TransitionRecommandee->semantique->semantique)));
                    break;
                    
                case 'narration':
                    $TransitionRecommandee->narration = $request['value'];
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
                    break;
            
                default:
                    $this->getResponse()->setStatusCode(404);
                    break;
            }
        
        } else {
            $this->getResponse()->setStatusCode(404);
        }
    }


}
