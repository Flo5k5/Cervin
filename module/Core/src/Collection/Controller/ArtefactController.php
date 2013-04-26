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
    	$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'), array('nom'=>'asc'));
    	return new ViewModel(array('types' => $TEartefacts, 'form' => null));
    }

	public function getFormAjaxAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			if ($this->params()->fromPost('name') == 'getform') {
				$type = $this->params()->fromPost('type');
				$TEartefact = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findOneBy(array('type'=>'artefact', 'nom'=>$type));
				$form = new ChampTypeElementForm($TEartefact);
	
				$viewModel = new ViewModel(array('success' => true, 'type_element_id' => $TEartefact->id, 'form' => $form));
				$viewModel->setTerminal(true);
				return $viewModel;
				
			} elseif ($this->params()->fromPost('name') == 'ajouter') {
				$type = $this->params()->fromPost('type');
				$TEartefact = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findOneBy(array('type'=>'artefact', 'nom'=>$type));
				if (!$TEartefact) {
					throw new Exception('Type d\'élément non trouvé au moment de la création de l\'artefact');
				}
				$artefact = new Artefact(null, $TEartefact);
				$form = new ChampTypeElementForm($TEartefact);
				$form->setInputFilter($artefact->getInputFilter());
				$form->setData($this->params()->fromPost('formdata'));
				if ($form->isValid()) {
					$datas = $form->getData();
					$artefact->populate($datas);
					$artefact->description = $this->params()->fromPost('description');
					$this->getEntityManager()->persist($artefact);
					$this->getEntityManager()->flush();
					return $this->getResponse()->setContent('true');
				} else {
					$viewModel = new ViewModel(array('success' => true, 'type_element_id' => $TEartefact->id, 'form' => $form));
					$viewModel->setTerminal(true);
					return $viewModel;
				}
				
			}
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

		if($Artefact==null){
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
		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			//$post = $this->params()->fromPost();
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				case 'titre':
					$Artefact->titre = $request['value'];
		            $this->getEntityManager()->persist($Artefact);
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;
				case 'description':
					$Artefact->description = $request['value'];
		            $this->getEntityManager()->persist($Artefact);
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				
				break;
				case 'data':
					$idData = (int) $this->params()->fromRoute('idData', 0);
					if (!$idData) {
						return $this->redirect()->toRoute('error');
					}
					try {
						$dataDB = $this->getEntityManager()->getRepository('Collection\Entity\Data')->findOneBy(array('id'=>$idData));
					}
					catch (\Exception $ex) {
						return $this->redirect()->toRoute('error');
					}
					switch ($dataDB->champ->format) {
		    	 		case 'texte':
		    	 			$dataDB->texte = $request['value'];   	 					
		    	 			break;
		    	 		case 'textarea':
		    	 			$dataDB->textarea = $request['value'];
		    	 			break;
		    	 		case 'date':
		    	 			$dataDB->date = new \DateTime($request['value']);
		    	 			break;
		    	 		case 'nombre':
		    	 			$dataDB->nombre = $request['value']; 
		    	 			break;
		    	 		case 'fichier':
		    	 			$dataDB->fichier = $request['value'];
		    	 			break;
		    	 		case 'url':
		    	 			$dataDB->url = $request['value'];
			            	break;
			            default:
			            	return $this->getResponse()->setContent(Json::encode(false));  
			            break;
		    	 	} // end switch
				
		            $this->getEntityManager()->persist($dataDB);
		            $this->getEntityManager()->flush();
			        return $this->getResponse()->setContent(Json::encode(true)); 
				break;
				default:
		            return $this->getResponse()->setContent(Json::encode(false));  
		        break;
			}
		}
		return new ViewModel(array('artefact' => $Artefact));
	}

}
