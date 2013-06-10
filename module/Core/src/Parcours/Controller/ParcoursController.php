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

}
