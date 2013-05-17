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
use Zend\Json\Json;

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
    	$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'));
    	$form = null;
    	$type_element_id = (int) $this->params()->fromRoute('type_element_id', 0);
    	if ($type_element_id) {
    		// Un type d'artefact a été choisi dans le select
    		// On affiche le formulaire correspondant à ce type d'artefact
    		$type_element = $this->getEntityManager()
    				->getRepository('Collection\Entity\TypeElement')
    				->findOneBy(array('type'=>'artefact', 'id'=>$type_element_id));
    		if ($type_element) {
    			$form = new ChampTypeElementForm($type_element);
    		} else {
    			echo "<script>alert(\"Erreur : Type d'artefact non trouvé\")</script>";
    			return new ViewModel(array('types' => $TEartefacts, 'form' => $form, 'type_element_id'=>$type_element_id));
    		}
    		
    		$request = $this->getRequest();
    		if ($request->isPost()) {
    			// Le formulaire a été posté
    			// On créé le nouvel artefact
    			$artefact = new Artefact(null, $type_element);
    			$form->setInputFilter($artefact->getInputFilter());
    			$data = array_merge_recursive(
    				$this->getRequest()->getPost()->toArray(),
    				$this->getRequest()->getFiles()->toArray()
    			);
    			$form->setData($data);
    			if ($form->isValid()) {
    				$artefact->populate($data);
    				$this->getEntityManager()->persist($artefact);
    				$this->getEntityManager()->flush();
    				$this->flashMessenger()->addSuccessMessage(sprintf('L\'artefact "%1$s" a bien ete créé.', $artefact->titre));
    				return $this->redirect()->toRoute('collection/consulter');
    			} else {
    				return new ViewModel(array('types' => $TEartefacts, 'form' => $form, 'type_element_id'=>$type_element_id));
    			}
    		}
    	}
    	return new ViewModel(array('types' => $TEartefacts, 'form' => $form, 'type_element_id'=>$type_element_id));
    }

	public function voirArtefactAction()
	{

		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->getResponse()->setStatusCode(404);
            return;
		}

		try {
			$Artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>$id));
		}
		catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
            return;
		}

		if($Artefact==null){
			$this->getResponse()->setStatusCode(404);
            return;
		}

		//$Artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>1));
		return new ViewModel(array('artefact' => $Artefact));
	}

	public function editArtefactAction()
	{

		$id = (int) $this->params()->fromRoute('id', 0);
		$artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>$id));
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\Data')->findBy(array('element'=>$artefact));
		if (!$id or $artefact === null or $datas === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				case 'titre':
					$artefact->titre = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;

				case 'description':
					$artefact->description = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;

				case 'data':

					$idData = (int) $this->params()->fromRoute('idData', 0);
					$data = $this->getEntityManager()->getRepository('Collection\Entity\Data')->findOneBy(array('id'=>$idData));
					if (!idData or $data === null) {
						$this->getResponse()->setStatusCode(404);
						return;
					}
					var_dump($request['value']);
					switch ($data->champ->format) {
		    	 		case 'texte':
		    	 			$data->texte = $request['value'];
		    	 			break;
		    	 		case 'textarea':
		    	 			$data->textarea = $request['value'];
		    	 			break;
		    	 		case 'date':
		    	 			$data->date = new \DateTime($request['value']);
		    	 			break;
		    	 		case 'nombre':
		    	 			$data->nombre = $request['value'];
		    	 			break;
		    	 		case 'fichier':
		    	 			$artefact->deleteFile($data);
		    	 			$artefact->updateFile($data, $request['value']['tmp_name'], $request['value']['name'], $request['value']['type']);
		    	 			break;
		    	 		case 'url':
		    	 			$data->url = $request['value'];
			            	break;
			            default:
			            	return $this->getResponse()->setContent(Json::encode(false));
			            break;
		    	 	} // end switch
		            $this->getEntityManager()->flush();
			        return $this->getResponse()->setContent(Json::encode(true));
				break;
				default:
		            return $this->getResponse()->setContent(Json::encode(false));  
		        break;
			}
		}
		return new ViewModel(array('artefact' => $artefact,'datas'=>$datas));
	}
	

	public function removeArtefactAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	
		$artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>$id));
		
		if ($artefact === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		foreach( ($artefact->datas) as $data){
			if($data->fichier !== null){
				$artefact->deleteFile($data);
			}
		}
		
		$this->getEntityManager()->remove($artefact);
		$this->getEntityManager()->flush();
		return $this->redirect()->toRoute('collection/consulter');
	}

}
