<?php
/**
 *
 */

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Collection\Form\ChampTypeElementForm;
use Zend\Json\Json;
use Zend\Form\Form;
use Zend\Form\Element;
use Collection\View\Helper\formatForm;
use Exception;
use Collection\Entity\Artefact;

class ArtefactController extends AbstractActionController
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
		return $this->redirect()->toRoute('collection/consulter');
    }

    public function ajouterAction()
    {
    	/*$request = $this->getRequest();
    	if ($request->isPost()) {
	    	$type_element = $this->params()->fromRoute('type_element', 0);
	    	if (!$type_element) {
	    		throw new Exception('Type d\'élément non trouvé au moment de la création de l\'artefact');
	    	}
	    	$form = new ChampTypeElementForm($type_element);
	    	$form->setData($request->getPost());
	    	$artefact = new Artefact();
	    	//if ($form->isValid()) {
	    		$artefact->populate($form->getData());
	    		$this->getEntityManager()->persist($artefact);
	    		$this->getEntityManager()->flush();
	    	
	    		// Redirect to list of albums
	    		return $this->redirect()->toRoute('collection/ajouter');
	    	//}
    	}*/
    	$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'));
    	return new ViewModel(array('types' => $TEartefacts, 'form' => null));
    }

    public function getFormAjaxAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) 
        {
            $type = $this->params()->fromPost('type');
            
        	$TEartefact = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findOneBy(array('type'=>'artefact', 'nom'=>$type));
        	$form = new ChampTypeElementForm($TEartefact);

        	
        	$viewModel = new ViewModel(array('success' => true, 'type' => $type, 'form' => $form));
        	$viewModel->setTerminal(true);
        	return $viewModel;

        } else {
        	return $this->redirect()->toRoute('artefact/ajouter');
        }
    }

}