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
use Parcours\Entity\SousParcours;
use Parcours\Form\ParcoursForm;
use Parcours\Entity\TransitionRecommandee;
use Parcours\Entity\SceneRecommandee;
use Zend\Json\Json;

/**
 * Controleur des parcours
 *
 * Permet la création, lecture, modification et suppression d'un parcours
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
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

	/**
	 * Affiche la liste des parcours
	 * 
	 */
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
    		
			$titre = '<a class="href-type-element" href="'
							.$this->url()->fromRoute('parcours/voir', array('id' => $parcours->id)).'">'
							.$escapeHtml($parcours->titre).'
						</a>';
    		
			$btn_supprimer = '<a href="#" 
					data-url="'.$this->url()->fromRoute('parcours/supprimer', array('id' => $parcours->id)).'" 
		    		class="btn btn-danger SupprimerParcours">
						<i class="icon-trash"></i> Supprimer
					</a>';
    		
    		$aaData[] = array(
    				$titre,
    				$dataTable->truncate($parcours->description, 250, ' ...', false, true),
    				$btn_supprimer
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
    $escapeHtml        = $viewHelperManager->get('escapeHtml');
    $form              = new ParcoursForm();
    $Parcours          = new Parcours();
    $request           = $this->getRequest();
    $form->bind($Parcours);

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

    public function supprimerAction() {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
    	if ($parcours === null || $id === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	try {
    		$parcours->sous_parcours_depart = null;
    		foreach ($parcours->sous_parcours as $sous_parcours) {
    			$sous_parcours->sous_parcours_suivant = null;
    			$sous_parcours->scene_depart = null;
    			$sous_parcours->parcours = null;
    			//$this->getEntityManager()->remove($sous_parcours);
    		}
    		$this->getEntityManager()->remove($parcours);
    		$this->getEntityManager()->flush();
    	} catch (\Exception $e) {
    		$this->flashMessenger()->addErrorMessage(sprintf('Erreur lors de la suppression du parcours.'));
    		return $this->getResponse()->setContent(Json::encode(true));
    	}
    	$this->flashMessenger()->addSuccessMessage(sprintf('Le parcours a bien été supprimé.'));
    	return $this->getResponse()->setContent(Json::encode(true));
    }
    
    /**
     * Affiche la fiche d'un parcours
     * 
     * @return void|\Zend\View\Model\ViewModel
     */
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
     * Modifie la sémantique ou la narration d'une transition 
     */
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
    /**  
     * Affichage du parcour avec halviz
     */
    public function voirParcourHalvizAction()
    {
       // $id = (int) $this->params('id', null);
        $id = 1;
        $Parcour = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
        if ($Parcour === null || $id === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }





$chl = '';

foreach ($Parcour->sous_parcours as $sous_parcour) {
  $chl .= 'subgraph cluster_'.$sous_parcour->id.' { color=blue;label = "'.$sous_parcour->titre.'";';
  foreach ( $sous_parcour->scenes as $scene) {
    $chl .= 's'.$scene->id.'[label="'.$scene->titre.'", color=orange] ';


  }
  foreach ( $sous_parcour->transitions as $transition) {
    $chl .='s'.$transition->scene_origine->id.'->'.'s'.$transition->scene_destination->id.'[label="'.$transition->semantique->semantique.'"]';

  }
  $chl .= '}';

}
  foreach ( $Parcour->transitions as $transition) {

    $chl .='s'.$transition->scene_origine->id.'->'.'s'.$transition->scene_destination->id.'[label="'.$transition->semantique->semantique.'", color=red] ';
  }




  $url = 'https://chart.googleapis.com/chart';
  $chd = 't:';
  for ($i = 0; $i < 150; ++$i) {
    $data = rand(0, 100000);
    $chd .= $data . ',';
  }
  $chd = substr($chd, 0, -1);

  // Add data, chart type, chart size, and scale to params.
  $chart = array(
    'cht' => 'gv',/*
    'chs' => '600x200',
    'chds' => '0,100000',*/
    'chl' => 'digraph unix {'.$chl.'}');

  // Send the request, and print out the returned bytes.
  $context = stream_context_create(
    array('http' => array(
      'method' => 'POST',
      'header'=>"Content-type: application/x-www-form-urlencoded\r\n".
                "Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n",
      'content' => http_build_query($chart))));
  $img = file_get_contents($url, false, $context);



echo '<img src="data:image/gif;base64,' . base64_encode($img) . '" />';



        $viewModel = new ViewModel(array('Parcour' => $Parcour,'img'=>$img));
        $viewModel->setTerminal(true);
        return $viewModel;











    }

    public function ajouterSousParcoursAction()
    {
        $idsp = (int) $this->params('idsp', null);
        $action = $this->params('type', null);
        if (null === $idsp or null === $action) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }
        $sousparcours = $this->getEntityManager()
                ->getRepository('Parcours\Entity\SousParcours')
                ->findOneBy(array('id'=>$idsp));

        $newsp = new SousParcours();
        $newsp->titre = 'Nouveau sous-parcours';
        $newsp->description = 'Description à écrire';
        $newsp->transitions = new \Doctrine\Common\Collections\ArrayCollection();
        $newsp->scenes = new \Doctrine\Common\Collections\ArrayCollection();
        $newScene = new SceneRecommandee();
        $newScene->titre = 'Nouvelle scène';
        $newScene->narration = 'Narration à écrire';
        $newsp->addScene($newScene);
        $newsp->scene_depart = $newScene;
        $newTransitionRecommandee = new TransitionRecommandee();
        $newTransitionRecommandee->narration = 'Nouvelle Transition';
        $sousparcours->parcours->addSousParcours($newsp);
        $newsp->parcours->addTransition($newTransitionRecommandee);
        $this->getEntityManager()->persist($newTransitionRecommandee);
        $this->getEntityManager()->persist($newScene);
        $this->getEntityManager()->persist($newsp);
        $this->getEntityManager()->flush();
        switch ($action)
        {
            case 'ajAvant': // On ajoute un sous-parcours avant $sousparcours
                if($sousparcours->parcours->sous_parcours_depart === $sousparcours)
                {
                    $sousparcours->parcours->sous_parcours_depart = $newsp;
                    $newTransitionRecommandee->scene_origine = $newScene;
                    $newTransitionRecommandee->scene_destination = $sousparcours->scene_depart;
                    $newsp->sous_parcours_suivant = $sousparcours;
                }
                else
                {
                    $tr_before = $this->getEntityManager()
                            ->getRepository('Parcours\Entity\TransitionRecommandee')
                            ->findOneBy(array('scene_destination'=>$sousparcours->scene_depart));
                    $pass = $tr_before->scene_origine;
                    $tr_before->scene_origine = $newScene;
                    $this->getEntityManager()->flush();
                    $newTransitionRecommandee->scene_origine = $pass;
                    $sp_before = $pass->sous_parcours;
                    $sp_before->sous_parcours_suivant = $newsp;
                    $this->getEntityManager()->flush();
                    $newsp->sous_parcours_suivant = $sousparcours;
                    $newTransitionRecommandee->scene_destination = $newScene;
                }
            break;
            case 'ajApres': // On ajoute un sous-parcours après $sousparcours
                if($sousparcours->sous_parcours_suivant === null)
                {
                    foreach ($sousparcours->scenes as $scene)
                    {
                        if($this->getEntityManager()
                            ->getRepository('Parcours\Entity\TransitionRecommandee')
                            ->findOneBy(array('scene_origine'=>$scene))
                            === null)
                        {
                            $last_scene = $scene;
                            break;
                        }
                    }
                    $newTransitionRecommandee->scene_origine = $last_scene;
                }
                else
                {
                    $tr_after = $this->getEntityManager()
                            ->getRepository('Parcours\Entity\TransitionRecommandee')
                            ->findOneBy(array('scene_destination'=>$sousparcours->sous_parcours_suivant->scene_depart));
                    $pass = $tr_after->scene_origine;
                    $tr_after->scene_origine= $newScene;
                    $newTransitionRecommandee->scene_origine = $pass;
                }
                $pass = $sousparcours->sous_parcours_suivant;
                $sousparcours->sous_parcours_suivant = $newsp;
                $this->getEntityManager()->flush();
                $newsp->sous_parcours_suivant = $pass;
                $newTransitionRecommandee->scene_destination = $newScene;
            break;
        }
        $this->getEntityManager()->flush();
        $this->flashMessenger()->addSuccessMessage(sprintf('Le sous-parcours a bien été ajouté'));
        return $this->redirect()->toRoute('parcours/voir', array('id' => $sousparcours->parcours->id));
    }
}
