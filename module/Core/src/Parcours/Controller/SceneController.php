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

class SceneController extends AbstractActionController
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
    	return $this->redirect()->toRoute('parcours');
    }

    public function voirSceneAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->getResponse()->setStatusCode(404);
            return;
		}

		try {
			$Scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$id));
		}
		catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
            return;
		}

		if($Scene==null){
			$this->getResponse()->setStatusCode(404);
            return;
		}

		$tr_before = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_destination'=>$Scene->id));
		$tr_after = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_origine'=>$Scene->id));

		if($tr_before === null)
		{
			$sc_before = null;
		}
		else
		{
			$sc_before = $tr_before->scene_origine;
		}

		if($tr_after === null)
		{
			$sc_after = null;
		}
		else
		{
			$sc_after = $tr_after->scene_destination;
		}

		return new ViewModel(array(
			'scene' => $Scene, 
			'precedente' => $sc_before,
			'suivante' => $sc_after
		));
    }

    public function removeSceneAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$id));
		
		if ($scene === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		$tr_before = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_destination'=>$id));
		$tr_after = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_origine'=>$id));

		if($tr_before === null && $tr_after === null) // c'est la seule
		{
			$this->flashMessenger()->addErrorMessage(sprintf('Impossible de supprimer la dernière scène de ce parcours.'));
			return $this->redirect()->toRoute('scene/voirScene', array('id' => $scene->id));
		}
		elseif($tr_before === null) // c'est la première
		{
			$scene->sous_parcours->scene_depart = $tr_after->scene_destination;
			$this->getEntityManager()->remove($tr_after);
		}
		elseif($tr_after === null)// c'est la dernière
		{
			$this->getEntityManager()->remove($tr_before);
		}
		else // elle est au milieu
		{
			$tr_after->scene_origine = $tr_before->scene_origine;
			$this->getEntityManager()->remove($tr_before);
		}

		$this->getEntityManager()->remove($scene);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('La scène a bien été supprimée.'));
		return $this->redirect()->toRoute('parcours');
	}

	public function ajouterSceneAction()
	{
		return new ViewModel();
	}

	public function editSceneAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$id));
		if (!$id or $scene === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				
				case 'titre':
					$scene->titre = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;

				case 'description':
					$scene->narration = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;

				/*///
				case 'data':

					$idData = (int) $this->params()->fromRoute('idData', 0);
					$data = $this->getEntityManager()->getRepository('Collection\Entity\Data')->findOneBy(array('id'=>$idData));
					if (!$idData or $data === null) {
						$this->getResponse()->setStatusCode(404);
						return;
					}
					
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
		    	 			$files = $this->params()->fromFiles();
		    	 			$file = $files['file-input'];
		    	 			if ($file != null) {
			    	 			$scene->deleteFile($data);
			    	 			$scene->updateFile($data, $file['tmp_name'], $file['name'], $file['type']);
		    	 			}
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
		        //*///
			}
			return $this->getResponse()->setContent(Json::encode(true));///
		}
		return new ViewModel(array('scene' => $scene));
	}
}