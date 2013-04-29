<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Zend\Form\Annotation\AnnotationBuilder;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Collection\Entity\Element;
use Collection\Entity\TypeElement;
use Collection\Entity\Champ;
use Collection\Form\ChampForm;
use Collection\Form\TypeElementForm;

class TypeElementController extends AbstractActionController
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

    	$TEmedias = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'media'));

    	return array(
    		'TEartefacts' => $TEartefacts,
    		'TEmedias' => $TEmedias,
    	);


    }

    public function addAction()
    {
        $mediaArtefact =  $this->params()->fromRoute('media-artefact');
        
        if ($this->getRequest()->isXmlHttpRequest()) 
        {
            $postData = $this->params()->fromPost();
            if($postData['name'] == 'ajTypeMedia')
            {
                $form = new TypeElementForm();

                $request = $this->getRequest();
                if ($postData['submit'] == 'true') {
                    $TypeElement = new TypeElement(null,$mediaArtefact);
                    $form->setInputFilter($TypeElement->getInputFilter());
                    $form->setData($request->getPost());

                    if ($form->isValid()) {
                        $TypeElement->populate($form->getData()); 
                        $this->getEntityManager()->persist($TypeElement);
                        $this->getEntityManager()->flush();
                        $this->flashMessenger()->addSuccessMessage(sprintf('<strong>Success!</strong> Le Type d\'element "%1$s" a bien ete créé.', $TypeElement->nom));
                        return $this->getResponse()->setContent(Json::encode(true));
                    }
                }
                
                $viewModel = new ViewModel(array('form'=>$form));
                $viewModel->setTerminal(true);
                return $viewModel;
            }
        }


    }

    public function editTypeElementAjaxAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) 
        {
        	$id = (int) $this->params()->fromRoute('id', 0);
        	
            if (!$id) {
                return $this->getResponse()->setContent(Json::encode(array('success'=>false,'error'=>'id Type Element')));
            }

            
            $TypeElement = $this->getEntityManager()->find('Collection\Entity\TypeElement', $id);
            if (null === $TypeElement) {
                $this->getResponse()->setStatusCode(404);
                return; 
            }
            $postData = $this->params()->fromPost();
            $idChamp = (int) $this->params()->fromRoute('idChamp', 0);
            if (!empty($idChamp)) {

            	
                $Champ = $this->getEntityManager()->find('Collection\Entity\Champ', $idChamp);
	            if (null === $Champ) {
                    $this->getResponse()->setStatusCode(404);
                    return; 
                }
            	
            	switch ($postData['name']) {
            		case 'label':
            			$Champ->label = $postData['value'];
		                $this->getEntityManager()->persist($Champ);
		                $this->getEntityManager()->flush();
                        return $this->getResponse()->setContent(Json::encode(array(true)));
            			break;
            		case 'description':
            			$Champ->description = $postData['value'];
		                $this->getEntityManager()->persist($Champ);
		                $this->getEntityManager()->flush();
                        return $this->getResponse()->setContent(Json::encode(array(true)));
            			break;
                    case 'supprimerChamp':
                        $this->getEntityManager()->remove($Champ);
                        $this->getEntityManager()->flush();
                        $this->flashMessenger()->addSuccessMessage(sprintf('<strong>Success!</strong> Le Champ "%1$s" a bien ete supprimer.', $Champ->label));
                        return $this->getResponse()->setContent(Json::encode(true));
                        break;
            		default:
            			return $this->getResponse()->setContent(Json::encode(array('success'=>false,'error'=>'name inconu')));
            			break;
            	}

            	return $this->getResponse()->setContent(Json::encode(array('success'=>false,'error'=>'switch ??')));


            } else {

            	switch ($postData['name']) {
            	case 'nom':
            		$TypeElement->nom = $postData['value'];
		            $this->getEntityManager()->persist($TypeElement);
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(array('success'=>true)));
                    break;
            	case 'ajChamp':

                    $form = new ChampForm();
                    if ($postData['submit'] != 'false')
                    {
                        $request = $this->getRequest();
                        $champ = new Champ();
                        $form->setInputFilter($champ->getInputFilter());
                        $form->setData($request->getPost());
                        if ($form->isValid()) {
                            
                            $champ->label = $request->getPost('label');
                            $champ->format = $request->getPost('format');
                            $champ->description = $request->getPost('description');
                            $champ->type_element = $TypeElement;

                            $this->getEntityManager()->persist($champ);
                            $this->getEntityManager()->flush();
                            $this->flashMessenger()->addSuccessMessage(sprintf('<strong>Success!</strong> Le Champ "%1$s" a bien ete ajouté.', $champ->label));
                            return $this->getResponse()->setContent(Json::encode(true));
                        }
                        else
                        {
                            $viewModel = new ViewModel(array('form' => $form));
                            $viewModel->setTerminal(true);
                            return $viewModel->setTemplate('Collection/Type-Element/addChampModal.phtml');
                        }
                    }


                    $viewModel = new ViewModel(array('form' => $form));
                    $viewModel->setTerminal(true);
                    return $viewModel->setTemplate('Collection/Type-Element/addChampModal.phtml');

                    break;
                case 'supprimerTypeElement':
                        $this->getEntityManager()->remove($TypeElement);
                        $this->getEntityManager()->flush();
                        $this->flashMessenger()->addSuccessMessage(sprintf('<strong>Success!</strong> Le Type d\'element "%1$s" a bien ete supprimer.', $TypeElement->nom));
                        return $this->getResponse()->setContent(Json::encode(true));
                        break;
                default:
                    return $this->getResponse()->setContent(Json::encode(array('success'=>false)));
                    break;
                }

            }
            

              
        }
    	
    }
    
}
