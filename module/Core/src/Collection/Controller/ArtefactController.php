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
    			// On créé un nouvel artefact
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
            $this->getResponse()->setStatusCode(404);
            return;
		}

		$ThisChamps = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->getThisChamps($id);
		$Artefact = $this->getEntityManager()->getRepository('Collection\Entity\Artefact')->findOneBy(array('id'=>$id));
		
		if (null === $ThisChamps and $Artefact === null) {
            $this->getResponse()->setStatusCode(404);
            return;
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
					$idChamp = (int) $this->params()->fromRoute('idChamp', 0);

					$Champ = $this->getEntityManager()->getRepository('Collection\Entity\Champ')->findOneBy(array('id'=>$idChamp));
					if (null === $Champ) {
				            $dataDB = new Data($Artefact,$idChamp);
				    }	
					$dataDB = $this->getEntityManager()->getRepository('Collection\Entity\Data')->findOneBy(array('element'=>$Artefact,'champ'=>$Champ));
					if (null === $dataDB) {
				        $dataDB = new Data($Artefact,$Champ);
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
		return new ViewModel(array('artefact' => $Artefact,'ThisChamps'=>$ThisChamps));
	}

}
