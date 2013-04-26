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
    	$TEmedias = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'media'), array('nom'=>'asc'));
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
					$media->description = $this->params()->fromPost('description');
                    $this->getEntityManager()->persist($media);
                    $this->getEntityManager()->flush();
                    $this->flashMessenger()->addSuccessMessage(sprintf('<strong>Succès!</strong> Le média "%1$s" a bien ete créé.', $media->titre));
                    return $this->getResponse()->setContent('true');
                } else {
                    $viewModel = new ViewModel(array('success' => true, 'type_element_id' => $TEmedia->id, 'form' => $form));
                    $viewModel->setTerminal(true);
                    return $viewModel;
                }
            }
        } else {        
            return $this->redirect()->toRoute('media/ajouter');
        }
    }

    public function voirMediaAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('error');
        }

        try {
            $Media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>$id));
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('error');
        }

        if($Media==null){
            return $this->redirect()->toRoute('error');
        }

        //$Media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>1));
        return new ViewModel(array('media' => $Media));
    }

    public function editMediaAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('error');
        }

        try {
            $Media = $this->getEntityManager()->getRepository('Collection\Entity\Media')->findOneBy(array('id'=>$id));
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
                    $Media->titre = $request['value'];
                    $this->getEntityManager()->persist($Media);
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
                break;
                case 'description':
                    $Media->description = $request['value'];
                    $this->getEntityManager()->persist($Media);
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
        return new ViewModel(array('media' => $Media));
    }

}