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
use Collection\Entity\Champ;
use Collection\Form\ChampForm;

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
    	
		return $this->getResponse()->setContent(Json::encode(array('success'=>false)));
    }

    public function editTypeElementAjaxAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) 
        {
        	$id = (int) $this->params()->fromRoute('id', 0);
        	
            if (!$id) {
                return $this->getResponse()->setContent(Json::encode(array('success'=>false,'error'=>'id Type Element')));
            }

            try {
                $TypeElement = $this->getEntityManager()->find('Collection\Entity\TypeElement', $id);
            }
            catch (\Exception $ex) {
            	return $this->getResponse()->setContent(Json::encode(array('success'=>false)));
            }
            $postData = $this->params()->fromPost();
            $idChamp = (int) $this->params()->fromRoute('idChamp', 0);
            if (!empty($idChamp)) {


            	try {
                $Champ = $this->getEntityManager()->find('Collection\Entity\Champ', $idChamp);
	            }
	            catch (\Exception $ex) {
	            	return $this->getResponse()->setContent(Json::encode(array('success'=>false)));
	            }
            	
            	switch ($postData['name']) {
            		case 'label':
            			$Champ->label = $postData['value'];
		                $this->getEntityManager()->persist($Champ);
		                $this->getEntityManager()->flush();
            			break;
            		case 'description':
            			$Champ->description = $postData['value'];
		                $this->getEntityManager()->persist($Champ);
		                $this->getEntityManager()->flush();
            			break;
            		default:
            			return $this->getResponse()->setContent(Json::encode(array('success'=>false)));
            			break;
            	}

            	return $this->getResponse()->setContent(Json::encode(array('success'=>true)));


            } else {

            	switch ($postData['name']) {
            	case 'nom':
            		$TypeElement->nom = $postData['value'];
		            $this->getEntityManager()->persist($TypeElement);
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(array('success'=>true)));
                    break;
            	case 'ajChamp':


/*$form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //$album->exchangeArray($form->getData());
                //$this->getAlbumTable()->saveAlbum($album);
                $album->populate($form->getData()); 
                $this->getEntityManager()->persist($album);
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }
        return array('form' => $form);*/
       // var_dump($postData);
                    $form = new ChampForm();
                    if ($postData['submit'] != 'false')
                    {
                        $request = $this->getRequest();
                        //var_dump($request);
                        $champ = new Champ($postData['label'],$TypeElement,$postData['format']);
                        $champ->description = $postData['description'];
                      //  $form->setInputFilter($champ->getInputFilter());
                       // $form->setData($request->getPost());
                      //  if ($form->isValid()) {
                         //   $champ->populate($form->getData()); 
                            $this->getEntityManager()->persist($champ);
                            $this->getEntityManager()->flush();
                       // }
                    }


                    $viewModel = new ViewModel(array('form' => $form));
                    $viewModel->setTerminal(true);
                    return $viewModel->setTemplate('Collection/Type-Element/addChampModal.phtml');
                    
                   // return $this->getResponse()->setContent(Json::encode(false))->setStatusCode(300);;

                    break;
                default:
                    return $this->getResponse()->setContent(Json::encode(array('success'=>false)));
                    break;
                }

            }
            

              
        }
    	
    }
    
}
