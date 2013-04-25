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
use Collection\Entity\Data;
use Zend\File\Transfer\Adapter\Http;

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
    	$request = $this->getRequest();
    	$form;
    	if ($request->isPost()) {
    		// Le formulaire d'ajout a été posté
    		// On récupère le type de l'artefact que l'on va créer
	    	$type_element_id = $this->params()->fromRoute('type_element_id');
	    	$type_element = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findOneBy(array('type'=>'artefact', 'id'=>$type_element_id));
	    	if (!$type_element) {
	    		throw new Exception('Type d\'élément non trouvé au moment de la création de l\'artefact');
	    	}
	    	$artefact = new Artefact(null, $type_element);
	    	$form = new ChampTypeElementForm($type_element);
	    	$form->setInputFilter($artefact->getInputFilter());
	    	$form->setData($request->getPost());
	    	if ($form->isValid()) {
					$upload = new Http();
					$upload->setDestination('upload');
				    $upload->receive();
	    		$datas = $form->getData();
	    		$artefact->populate($datas);
	    		$this->getEntityManager()->persist($artefact);
	    		$this->getEntityManager()->flush();
	    		return $this->redirect()->toRoute('collection/consulter');
	    	} else {
	    		$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'));
	    		return new ViewModel(array('types' => $TEartefacts, 'form' => $form, 'type' => $type_element));
	    	}
    	}
    	$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'));
    	return new ViewModel(array('types' => $TEartefacts, 'form' => null, 'type' => 'none'));
    }

	public function getFormAjaxAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			$type = $this->params()->fromPost('type');
			$TEartefact = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findOneBy(array('type'=>'artefact', 'nom'=>$type));
			$form = new ChampTypeElementForm($TEartefact);

			$viewModel = new ViewModel(array('success' => true, 'type_element_id' => $TEartefact->id, 'form' => $form));
			$viewModel->setTerminal(true);
			return $viewModel;
		} else {
			return $this->redirect()->toRoute('artefact/ajouter');
		}
	}


	public function voirArtefactAction()
	{

		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('error');
		}

		try {
			$Artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>$id));
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('error');
		}


		//$Artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>1));
		return new ViewModel(array('artefact' => $Artefact));
	}

	public function editArtefactAction()
	{

		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('error');
		}

		try {
			$Artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>$id));
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('error');
		}


		//$Artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>1));
		return new ViewModel(array('artefact' => $Artefact));
	}

}
