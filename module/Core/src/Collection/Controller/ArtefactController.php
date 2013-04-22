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
use Collection\View\Helper\formatForm;

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
    	$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'));
		return new ViewModel(array('types' => $TEartefacts));
    }

    public function ajouterAction()
    {
    	$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'));
    	return new ViewModel(array('types' => $TEartefacts));
    }

    public function getFormAjaxAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) 
        {
            $type = $this->params()->fromPost('type');

        	$TEartefactArray = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact', 'nom'=>$type));
        	$TEartefact = $TEartefactArray[0];
        	$form=new ChampTypeElementForm($TEartefact);
        	/*
        	$strform="";
        	$form->prepare();
        	$form->setAttribute('action', $this->url('artefact'));
        	$form->setAttribute('method', 'post');
        	$form->setAttribute('class','form-horizontal');
        	$strform .= $this->form()->openTag($form);
        	foreach ($form as $element):

    		endforeach;
        	$strform .= $this->form()->closeTag();
        	//*///cela ne fonctionne pas !! il n'arrive pas à appeler $this->form() est-ce une méthode réservée aux vues ?
        	/*
        	$vh=new formatForm();
        	$strform=$vh.__invoke($form);
        	//*///ne marche pas non plus il ne trouve pas la classe Collection/View/Helper/formatForm alors qu'elle existe, problème de routes ?
        	return $this->getResponse()->setContent(Json::encode(array(
        		'success' => true,
        		'typereturned' => $type,
        		'form' => 'le formulaire est affiché yeah' /*$strform*//*$this->formatForm($form)*/ //meme problème $this->form()
    		)));
        } else {
            return $this->redirect()->toRoute('artefact/ajouter');
        }
    }

    private function formatForm($form)
    {
        $returnv="";
        $form->prepare();
        $form->setAttribute('action', $this->url('artefact'));
        $form->setAttribute('method', 'post');
        $form->setAttribute('class','form-horizontal');
        $returnv .= $this->form()->openTag($form);
        
        foreach ($form as $element):

        endforeach;

        //$returnv .= 
        $returnv .= $this->form()->closeTag();
        return $returnv;
    }
}