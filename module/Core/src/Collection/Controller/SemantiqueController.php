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
		$semantiquesArtefact = $this->getEntityManager()->getRepository('Collection\Entity\SemantiqueArtefact')->findAll();
		return new ViewModel(array('semantiquesArtefact'=>$semantiquesArtefact));
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
			 	$this->flashMessenger()->addSuccessMessage(sprintf('<strong>Success!</strong> La semantique a bien ete créé.<br>%1$s', '['.$SemantiqueArtefact->type_origine->nom.'] '.$SemantiqueArtefact->semantique.' ['.$SemantiqueArtefact->type_destination->nom.']'));
	            return $this->redirect()->toRoute('semantique');
		    }
		}

		return new ViewModel(array('form'=>$form));

	}

	public function modifierAction()
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

	 	$typeElementsArtefact = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'));
	 	$typeElementsArtefactArray = array();
		$typeElementsArtefactArray2 = array();
		foreach ($typeElementsArtefact as $typeElementArtefact) {
			$typeElementsArtefactArray[$typeElementArtefact->id] = $typeElementArtefact->nom;
			$typeElementsArtefactArray2[]=$typeElementArtefact->id;

		}
	    $form = new SemantiqueForm($typeElementsArtefactArray);
	    $form->bind($SemantiqueArtefact);
	    
	    $request = $this->getRequest();
	    if ($request->isPost()) {
	    	$form->setInputFilter($SemantiqueArtefact->getInputFilter($typeElementsArtefactArray2));
		    $form->setData($request->getPost());
		    if ($form->isValid()) {
		        $this->getEntityManager()->persist($SemantiqueArtefact);
		        $this->getEntityManager()->flush();
		 		$this->flashMessenger()->addSuccessMessage(sprintf('<strong>Success!</strong> La semantique a bien ete modifiée.<br>%1$s', '['.$SemantiqueArtefact->type_origine->nom.'] '.$SemantiqueArtefact->semantique.' ['.$SemantiqueArtefact->type_destination->nom.']'));
                return $this->redirect()->toRoute('semantique');
		    }
	    }
	 
	    return array(
	      'form' => $form,
	      'id' => $id
	    );
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
        return $this->redirect()->toRoute('semantique');
        
	}
}
