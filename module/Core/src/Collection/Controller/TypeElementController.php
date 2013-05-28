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
use Collection\Entity\Data;
use Collection\Entity\DataDate;
use Collection\Entity\DataFichier;
use Collection\Entity\DataNombre;
use Collection\Entity\DataTexte;
use Collection\Entity\DataUrl;
use Collection\Entity\DataTextarea;
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

    /**
     * On renvoi à la vue tous les types d'artefacts et de médias qu'elle doit gérer
     * @return multitype:unknown
     */
    public function indexAction()
    {
    	$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'));
    	$TEmedias = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'media'));
    	return array(
    		'TEartefacts' => $TEartefacts,
    		'TEmedias' => $TEmedias,
    	);
    }

    /**
     * Ajout d'un nouveau type d'élément
     * A COMMENTER !!!!
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml        = $viewHelperManager->get('escapeHtml');
        
        $mediaArtefact     = $this->params()->fromRoute('media-artefact');
        
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
                        $this->flashMessenger()->addSuccessMessage(sprintf('Le Type d\'element "%1$s" a bien ete créé.', $escapeHtml( $TypeElement->nom ) ) );
                        return $this->getResponse()->setContent(Json::encode(true));
                    }
                }
                $viewModel = new ViewModel(array('form'=>$form));
                $viewModel->setTerminal(true);
                return $viewModel;
            }
        }
    }

    /**
     * A COMMENTER ELLE EST SACREMENT VIOLENTE CETTE FONCTION YA PLEIN DE TRUCS A EXPLIQUER !!
     */
    public function editTypeElementAjaxAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
    	if ($this->getRequest()->isXmlHttpRequest()) 
        {
        	$id = (int) $this->params()->fromRoute('id', 0);
            $TypeElement = $this->getEntityManager()->find('Collection\Entity\TypeElement', $id);
            if (null === $TypeElement or $id === null) {
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
						if( $Champ->format === 'fichier' ){
							$Champ->deleteFiles();
						}
						$this->getEntityManager()->remove($Champ);
						$this->getEntityManager()->flush();
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
                            
                            $elements_existants = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findBy(array('type_element' => $TypeElement));
                            $data = null;
                            foreach ($elements_existants as $element) {
                            	switch ($champ->format) {
                            		case 'texte':
                            			$data = new DataTexte($element, $champ);
                            			break;
                            		case 'textarea':
                            			$data = new DataTextarea($element, $champ);
                            			break;
                            		case 'nombre':
                            			$data = new DataNombre($element, $champ);
                            			break;
                            		case 'url':
                            			$data = new DataUrl($element, $champ);
                            			break;
                            		case 'date':
                            			$data = new DataDate($element, $champ);
                            			break;
                            		case 'fichier':
                            			$data = new DataFichier($element, $champ);
                            			break;
                            	}
        						$element->datas->add($data);
        						$this->getEntityManager()->persist($element);
                            }
                            $this->getEntityManager()->flush();
                            $this->flashMessenger()->addSuccessMessage(sprintf('Le Champ "%1$s" a bien ete ajouté.', $escapeHtml($champ->label)));
                            return $this->getResponse()->setContent(Json::encode(true));
                        } else {
                        	// Form non valide
                            $viewModel = new ViewModel(array('form' => $form));
                            $viewModel->setTerminal(true);
                            return $viewModel->setTemplate('Collection/Type-Element/addChampModal.phtml');
                        }
                    } 
                    $viewModel = new ViewModel(array('form' => $form));
                    $viewModel->setTerminal(true);
                    return $viewModel->setTemplate('Collection/Type-Element/addChampModal.phtml');
                    break; // end case ajChamp
                    
                case 'supprimerTypeElement':
	                $champsFichier = $this->getEntityManager()->getRepository('Collection\Entity\Champ')->findBy(array('type_element' => $TypeElement, 'format' => 'fichier'));
	                if ($champsFichier !== null) {
	                	foreach ($champsFichier as $champ) {
	                		$champ->deleteFiles();
	                	}
	                }
                    $this->getEntityManager()->remove($TypeElement);
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
                    break;
                    
                default:
                    return $this->getResponse()->setContent(Json::encode(array('success'=>false)));
                    break;
                } //end swith $postData['nama']
            } // end if (!empty($idChamp))
        } // end if ($this->getRequest()->isXmlHttpRequest()) 
    } // end action
    
}
