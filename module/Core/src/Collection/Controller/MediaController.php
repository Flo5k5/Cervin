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
use Collection\Entity\Media;
use Collection\Entity\Data;
use Zend\File\Transfer\Adapter\Http;
use Zend\Json\Json;

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
        $form = null;
        $type_element_id = (int) $this->params()->fromRoute('type_element_id', 0);
        if ($type_element_id) {
            // On affiche le formulaire correspondant à ce type de média
            $type_element = $this->getEntityManager()
                    ->getRepository('Collection\Entity\TypeElement')
                    ->findOneBy(array('type'=>'media', 'id'=>$type_element_id));
            if ($type_element) {
                $form = new ChampTypeElementForm($type_element);
            } else {
                echo "<script>alert(\"Erreur : Type de média non trouvé\")</script>";
                return new ViewModel(array('types' => $TEmedias, 'form' => $form, 'type_element_id'=>$type_element_id));
            }
            
            $request = $this->getRequest();
            if ($request->isPost()) {
                // On créé un nouveau média
                $media = new Media(null, $type_element);
                $form->setInputFilter($media->getInputFilter());
                $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(),
                    $this->getRequest()->getFiles()->toArray()
                );
                $form->setData($data);
                if ($form->isValid()) {
                    $media->populate($data);
                    $this->getEntityManager()->persist($media);
                    $this->getEntityManager()->flush();
                    $this->flashMessenger()->addSuccessMessage(sprintf('Le média "%1$s" a bien ete créé.', $media->titre));
                    return $this->redirect()->toRoute('collection/consulter');
                } else {
                    return new ViewModel(array('types' => $TEmedias, 'form' => $form, 'type_element_id'=>$type_element_id));
                }
            }
        }
        return new ViewModel(array('types' => $TEmedias, 'form' => $form, 'type_element_id'=>$type_element_id));
    }

    public function voirMediaAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        try {
            $Media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>$id));
        }
        catch (\Exception $ex) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        if($Media==null){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        //$Media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>1));
        return new ViewModel(array('media' => $Media));
    }

    public function editMediaAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>$id));
    	$datas = $this->getEntityManager()->getRepository('Collection\Entity\Data')->findBy(array('element'=>$media));
    	if (!$id or $media === null or $datas === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	
        if ($this->getRequest()->isXmlHttpRequest()) 
        {
            //$post = $this->params()->fromPost();
            $request = $this->params()->fromPost();
            switch ($request['name']) {
                case 'titre':
                    $media->titre = $request['value'];
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
                break;

                case 'description':
                    $media->description = $request['value'];
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
                            $data->fichier = $request['value'];
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
        return new ViewModel(array('media' => $media,'datas'=>$datas));
    }


    public function removeMediaAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
    
        $media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>$id));
        
        if ($media === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
    	foreach( ($media->datas) as $data){
			if($data->fichier !== null){
				$media->deleteFile($data);
			}
		}
        
        $this->getEntityManager()->remove($media);
        $this->getEntityManager()->flush();
        return $this->redirect()->toRoute('collection/consulter');
    }

}