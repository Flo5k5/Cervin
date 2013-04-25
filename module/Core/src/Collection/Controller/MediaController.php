<?php
/**
 *
 */

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Collection\Form\ChampTypeElementForm;
use Zend\Form\Form;
use Zend\Form\Element;
use Collection\View\Helper\formatForm;
use Exception;
use Collection\Entity\Media;
use Collection\Entity\Data;

class MediaController extends AbstractActionController
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
    	$TEmedias = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'media'));
		return new ViewModel(array('types' => $TEmedias, 'form' => null));
    }

    public function getFormAjaxAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) 
        {
            if ($this->params()->fromPost('name') == 'getform') {
                $type = $this->params()->fromPost('type');
                $TEmedia = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findOneBy(array('type'=>'media', 'nom'=>$type));
                $form = new ChampTypeElementForm($TEmedia);
    
                $viewModel = new ViewModel(array('success' => true, 'type_element_id' => $TEmedia->id, 'form' => $form));
                $viewModel->setTerminal(true);
                return $viewModel;
                
            } elseif ($this->params()->fromPost('name') == 'ajouter') {
                $type = $this->params()->fromPost('type');
                $TEmedia = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findOneBy(array('type'=>'media', 'nom'=>$type));
                if (!$TEmedia) {
                    throw new Exception('Type d\'élément non trouvé au moment de la création du média');
                }
                $media = new Media(null, $TEmedia);
                $form = new ChampTypeElementForm($TEmedia);
                $form->setInputFilter($media->getInputFilter());
                $form->setData($this->params()->fromPost('formdata'));
                if ($form->isValid()) {
                    $datas = $form->getData();
                    $media->populate($datas);
                    $this->getEntityManager()->persist($media);
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent('true');
                } else {
                    $viewModel = new ViewModel(array('success' => true, 'type_element_id' => $TEmedia->id, 'form' => $form));
                    $viewModel->setTerminal(true);
                    return $viewModel;
                }
            }
        } else {        
            return $this->redirect()->toRoute('artefact/ajouter');
        }
    }
}