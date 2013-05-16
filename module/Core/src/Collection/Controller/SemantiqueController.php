<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Collection\Form\SemantiqueForm;
use Collection\Entity\SemantiqueArtefact;
use Zend\Json\Json;

class SemantiqueController extends AbstractActionController
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

	public function indexAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {
			$params = $this->params()->fromQuery();
    
            $entityManager = $this->getEntityManager()
                ->getRepository('Collection\Entity\SemantiqueArtefact');
        
            $dataTable = new \Collection\Model\SemantiqueDataTable($params);
            $dataTable->setEntityManager($entityManager);
            
            $dataTable->setConfiguration(array(
                'type_origine',
                'semantique',
                'type_destination'
            ));

            $aaData = array();
            
            
            foreach ($dataTable->getPaginator() as $semantique) {
				
            	$btn_supprimer = '<a href="#" data-url="'
            		.$this->url()->fromRoute('semantique/supprimer', array('id' => $semantique->id))
            		.'" data-value="['.$semantique->type_origine->nom.'] '
            		.$semantique->semantique.' ['
            		.$semantique->type_destination->nom.']" 
            		class="btn btn-danger SupprimerSemantique"
            		><i class="icon-trash"></i> Supprimer</a>';

                $aaData[] = array(
                    '<span> '. $semantique->type_origine->nom .' </span>',
                    '<span class="edit CursorPointer"
                    	data-url="'.$this->url()->fromRoute("semantique/modifier", array("id" => $semantique->id)).'"
                    	data-name="semantique"data-type="text" data-pk="1"> '.
            			$semantique->semantique .
                	'</span>',
                    '<span> '. $semantique->type_destination->nom .' </span>',
                    $btn_supprimer
                );
            }
            $dataTable->setAaData($aaData);
            
            return $this->getResponse()->setContent($dataTable->findAll());
		}
		else{
			$semantiquesArtefact = $this->getEntityManager()->getRepository('Collection\Entity\SemantiqueArtefact')->findAll();
			return new ViewModel(array('semantiquesArtefact'=>$semantiquesArtefact));
		}
	}

	public function ajouterAction()
	{
		$typeElementsArtefact = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'), array('nom'=>'ASC'));

		$typeElementsArtefactArray = array();
		$typeElementsArtefactArray2 = array();
		foreach ($typeElementsArtefact as $typeElementArtefact) {
			$typeElementsArtefactArray[$typeElementArtefact->id] = $typeElementArtefact->nom;
			$typeElementsArtefactArray2[]=$typeElementArtefact->id;

		}

        $form = new SemantiqueForm($typeElementsArtefactArray);
		$SemantiqueArtefact = new SemantiqueArtefact();
	    $form->bind($SemantiqueArtefact);
		    
		$request = $this->getRequest();
		if ($request->isPost()) {
		    $form->setInputFilter($SemantiqueArtefact->getInputFilter($typeElementsArtefactArray2));
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$post = $request->getPost();
				$SemantiqueArtefact->type_destination = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->find($post['type_destination']);
				$SemantiqueArtefact->type_origine = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->find($post['type_origine']);
			    $this->getEntityManager()->persist($SemantiqueArtefact);
			    $this->getEntityManager()->flush();
			 	$this->flashMessenger()->addSuccessMessage(sprintf('La sémantique a bien été créé.<br>%1$s', '['.$SemantiqueArtefact->type_origine->nom.'] '.$SemantiqueArtefact->semantique.' ['.$SemantiqueArtefact->type_destination->nom.']'));
	            return $this->redirect()->toRoute('semantique');
		    }
		}

		return new ViewModel(array('form'=>$form));

	}

	public function modifierAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) 
        {
        	
			$id = (int) $this->params('id', null);
		    if (null === $id) {
		        $this->getResponse()->setStatusCode(404);
				return; 
		    }

			$SemantiqueArtefact = $this->getEntityManager()->getRepository('Collection\Entity\SemantiqueArtefact')->findOneBy(array('id'=>$id));
			if ($SemantiqueArtefact === null) {
				$this->getResponse()->setStatusCode(404);
				return; 
			}
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				case 'semantique':
					$SemantiqueArtefact->semantique = $request['value'];
					$this->getEntityManager()->persist($SemantiqueArtefact);
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

	public function supprimerAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->getResponse()->setStatusCode(404);
			return; 
        }
        
			$SemantiqueArtefact = $this->getEntityManager()->getRepository('Collection\Entity\SemantiqueArtefact')->findOneBy(array('id'=>$id));
		if ($SemantiqueArtefact === null) {
			$this->getResponse()->setStatusCode(404);
			return; 
		}
        

        $this->getEntityManager()->remove($SemantiqueArtefact);
        $this->getEntityManager()->flush();
	 	$this->flashMessenger()->addSuccessMessage(sprintf('La sémantique a bien été supprimée.<br>%1$s', '['.$SemantiqueArtefact->type_origine->nom.'] '.$SemantiqueArtefact->semantique.' ['.$SemantiqueArtefact->type_destination->nom.']'));

        return $this->redirect()->toRoute('semantique');
        
	}

}
