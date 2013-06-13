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
    		
			$titre = '<a href="'
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
    	/*try {
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
    	}*/
    	$this->flashMessenger()->addErrorMessage(sprintf('La suppression d\'un parcours n\'est pas encore implémentée.'));
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
        
        /* Génération du graphe du parcours au format dot */
        
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
        $dot = 'Départ [shape="plaintext"];' . "\n";
        $dot .= 'Départ -> s' . $Parcours->sous_parcours_depart->scene_depart->id.'[style=dashed];' . "\n";
        foreach ( $Parcours->transitions as $transition) {
        	// Transitions inter-sous-parcours
        	$semantique = ($transition->semantique) ? $transition->semantique->semantique : 'Sémantique inconnue' ;
        	$dot .='s'.$transition->scene_origine->id.' -> '.'s'.$transition->scene_destination->id;
        	$dot .= '[edgetooltip="'.$escapeHtml($semantique).'",color="darkblue",penwidth="3",fontcolor="darkblue"];' . "\n";
        }
        foreach ($Parcours->sous_parcours as $sous_parcours) {
        	// Sous-parcours
        	$dot .= 'subgraph cluster_'.$sous_parcours->id.'{';
        	$dot .= 'color="darkgreen";';
        	$dot .= 'label = "'.$escapeHtml($sous_parcours->titre).'";';
        	$dot .= 'tooltip = "'.$escapeHtml($sous_parcours->titre).'";';
        	$dot .= 'fontcolor="darkgreen";';
        	$dot .= 'fontsize="20";';
        	$dot .= 'style="dashed";' . "\n";
        	foreach ( $sous_parcours->transitions as $transition) {
        		// Transition
        		$semantique = ($transition->semantique) ? $transition->semantique->semantique : 'Sémantique inconnue' ;
        		$style = ($transition instanceOf \Parcours\Entity\TransitionRecommandee) ? 'color="blue", penwidth="3", fontcolor="blue"' : 'color="grey", fontcolor="grey", penwidth="2"' ;
        		$dot .='s'.$transition->scene_origine->id.' -> '.'s'.$transition->scene_destination->id.'['.$style.', edgetooltip="'.$escapeHtml($semantique).'"];' . "\n";
        	}
        	foreach ( $sous_parcours->scenes as $scene) {
        		// Scene
        		if ($scene instanceOf \Parcours\Entity\SceneRecommandee) {
        			$style = 'color="blue", style=bold, fontcolor="darkblue"';
        		} elseif ( ($scene->transitions_secondaires_entrantes == null 
        				|| $scene->transitions_secondaires_entrantes->count() == 0)
        				&& ($scene->transitions_secondaires == null 
        				|| $scene->transitions_secondaires->count() == 0) ) {
        			$style = 'color="red", fontcolor="darkred"';
        		} else {
        			$style = 'color="grey", fontcolor="grey"';
        		}
        		//$style = ($scene instanceOf \Parcours\Entity\SceneRecommandee) ? 'color="blue", style=bold, fontcolor="darkblue"' : 'color="grey", fontcolor="grey"' ;
        		$dot .= 's'.$scene->id.'[label="'.$escapeHtml($scene->titre).'", '.$style.', shape="box", URL="'.$this->url()->fromRoute('scene/voirScene', array('id' => $scene->id)).'"];' . "\n";
        	}
        	 
        	$dot .= '}' . "\n";
        }
        
        return new ViewModel(array(
        		'Parcours'=>$Parcours,
        		'SemantiqueTransitions'=>$SemantiqueTransitions, 
        		'dot'=>$dot));
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
            $Transition = $this->getEntityManager()
	            ->getRepository('Parcours\Entity\Transition')
	            ->findOneBy(array('id'=>$id));
	            
            if ($Transition === null || $id === null) {
                $this->getResponse()->setStatusCode(404);
                return;
            }
            
            $request = $this->params()->fromPost();
            switch ($request['name']) {
                case 'semantique':
                $SemantiqueTransition = $this->getEntityManager()
                ->getRepository('Parcours\Entity\SemantiqueTransition')
                ->findOneBy(array('id'=>$request['value']));
                $Transition->semantique = $SemantiqueTransition;
                $this->getEntityManager()->flush();
                return $this->getResponse()->setContent(Json::encode(array('return'=>$Transition->semantique->semantique)));
                break;

                case 'narration':
                $Transition->narration = $request['value'];
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
    
    public function supprimerTransitionSecAction()
    {
    	$id = (int) $this->params('id', null);
    	$transition = $this->getEntityManager()
    		->getRepository('Parcours\Entity\Transition')
    		->findOneBy(array('id'=>$id));
    	if ($transition === null || $id === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$this->getEntityManager()->remove($transition);
    	$this->getEntityManager()->flush();
    	$this->flashMessenger()->addSuccessMessage(sprintf('La transition a bien été supprimée.'));
    	return $this->getResponse()->setContent(Json::encode(true));
    }

    public function ajouterTransitionSecAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		$request = $this->params()->fromPost();
    		
	    	$idSceneOrigine = $request['idSceneOrigine'];
	    	$sceneOrigine = $this->getEntityManager()
		    	->getRepository('Parcours\Entity\Scene')
		    	->findOneBy(array('id'=>$idSceneOrigine));
	    	if ($sceneOrigine === null || $idSceneOrigine === null ) {
	    		$this->getResponse()->setStatusCode(404);
	    		return;
	    	}
	    	
	    	$idSceneDestination = $request['idSceneDestination'];
	    	if ($idSceneDestination == 0) {
	    		// Pas de scène destination précisée pour la nouvelle transition secondaire
	    		// On doit en créer une
	    		$sceneDestination = new \Parcours\Entity\SceneSecondaire();
	    		$sceneDestination->titre = "Nouvelle scène secondaire";
	    		$sceneDestination->narration = "";
	    		$sceneDestination->elements = new \Doctrine\Common\Collections\ArrayCollection();
	    		$sceneOrigine->sous_parcours->addScene($sceneDestination);
	    		$this->getEntityManager()->persist($sceneDestination);
	    		//$manager->flush();
	    	} else {
	    		$sceneDestination = $this->getEntityManager()
	    			->getRepository('Parcours\Entity\Scene')
	    			->findOneBy(array('id'=>$idSceneDestination));
	    	}
	    	if ($sceneDestination === null || $idSceneDestination === null ) {
	    		$this->getResponse()->setStatusCode(404);
	    		return;
	    	}
	    	
	    	$transition = new \Parcours\Entity\TransitionSecondaire();
	    	$transition->narration = "Nouvelle transition";
	    	$transition->scene_origine = $sceneOrigine;
	    	$transition->scene_destination = $sceneDestination;
	    	
	    	$sceneOrigine->sous_parcours->addTransition($transition);
	    	$this->getEntityManager()->persist($transition);
	    	$this->getEntityManager()->flush();
	    	
	    	$this->flashMessenger()->addSuccessMessage(sprintf('La transition a bien été ajoutée.'));
	    	return $this->redirect()->toRoute('scene/editScene', array('id' => $idSceneOrigine));
    	} else {
    		$this->getResponse()->setStatusCode(404);
    	}
    }
    
    /**
     * Affichage du parcour avec halviz
     */
    public function voirParcourHalvizAction()
    {
      $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
      $escapeHtml = $viewHelperManager->get('escapeHtml');
      $id = (int) $this->params('id', null);
      $Parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
      if ($Parcours === null || $id === null) {
          $this->getResponse()->setStatusCode(404);
          return;
      }
      // création du dot
      $dot = 'Départ [shape="plaintext"];' . "\n";
      $dot .= 'Départ -> s' . $Parcours->sous_parcours_depart->scene_depart->id.'[style=dashed];' . "\n";
      foreach ( $Parcours->transitions as $transition) {
      		// Transitions inter-sous-parcours
      		$semantique = ($transition->semantique) ? $transition->semantique->semantique : 'Sémantique inconnue' ;
        	$dot .='s'.$transition->scene_origine->id.' -> '.'s'.$transition->scene_destination->id;
        	$dot .= '[edgetooltip="'.$escapeHtml($semantique).'",color="darkblue",penwidth="3",fontcolor="darkblue"];' . "\n";
      }
      foreach ($Parcours->sous_parcours as $sous_parcours) {
      		// Sous-parcours
	        $dot .= 'subgraph cluster_'.$sous_parcours->id.'{';
	        $dot .= 'color="darkgreen";';
	        $dot .= 'label = "'.$escapeHtml($sous_parcours->titre).'";';
	        $dot .= 'tooltip = "'.$escapeHtml($sous_parcours->titre).'";';
	        $dot .= 'fontcolor="darkgreen";';
	        $dot .= 'fontsize="20";';
	        $dot .= 'style="dashed";' . "\n";
	        foreach ( $sous_parcours->transitions as $transition) {
	        	// Transition
	        	$semantique = ($transition->semantique) ? $transition->semantique->semantique : 'Sémantique inconnue' ;
	        	$style = ($transition instanceOf \Parcours\Entity\TransitionRecommandee) ? 'color="blue", penwidth="3", fontcolor="blue"' : 'color="grey", fontcolor="grey", penwidth="2"' ;
	        	$dot .='s'.$transition->scene_origine->id.' -> '.'s'.$transition->scene_destination->id.'['.$style.', edgetooltip="'.$escapeHtml($semantique).'"];' . "\n";
	        }
	        foreach ( $sous_parcours->scenes as $scene) {
	        	// Scene
	        	$style = ($scene instanceOf \Parcours\Entity\SceneRecommandee) ? 'color="blue", style=bold, fontcolor="darkblue"' : 'color="grey", fontcolor="grey"' ;
	        	$dot .= 's'.$scene->id.'[label="'.$escapeHtml($scene->titre).'", '.$style.', shape="box", URL="'.$this->url()->fromRoute('scene/voirScene', array('id' => $scene->id)).'"];' . "\n";
	        }
	        
	        $dot .= '}' . "\n";
      }
      return new ViewModel(array('Parcours' => $Parcours,'dot'=>$dot));
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
    
    public function supprimerSousParcoursAction()
    {
    	$id = (int) $this->params()->fromRoute('idsp', 0);
    	$sous_parcours = $this->getEntityManager()->getRepository('Parcours\Entity\SousParcours')->findOneBy(array('id'=>$id));
    	if ($sous_parcours === null or $id === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$parcours = $sous_parcours->parcours;
    	
    	//$this->getEntityManager()->remove($scene);
    	//$this->getEntityManager()->flush();
    	$this->flashMessenger()->addErrorMessage(sprintf('La suppression d\'un sous-parcours n\'est pas encore implémentée.'));
    	return $this->getResponse()->setContent(Json::encode(true));
    }
    
    public function editSousParcoursAction()
    {
    	$id = (int) $this->params()->fromRoute('idsp', 0);
    	$sous_parcours = $this->getEntityManager()->getRepository('Parcours\Entity\SousParcours')->findOneBy(array('id'=>$id));
    	if (!$id or $sous_parcours === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$request = $this->params()->fromPost();
    	$sous_parcours->titre = $request['value'];
    	$this->getEntityManager()->flush();
    	return $this->getResponse()->setContent(Json::encode(true));
    }
    
}
