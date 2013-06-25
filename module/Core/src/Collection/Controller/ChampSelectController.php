<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Collection\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Collection\Form\ChampForm;
use Doctrine\DBAL\DriverManager;
use Zend\Json\Json;

/**
 * Controleur du champ select
 *
 * Permet l'ajout , la modification ou la supression des Selects
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class ChampSelectController extends AbstractActionController
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	/**
	 * Initialisation de l'Entity Manager
	 *
	 * @param Doctrine\ORM\EntityManager
	 * @return void
	 */
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Retourne l'Entity Manager
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
	 * Affiche la Datatable de la collection ou retourne une liste de tous les éléments à la Datatable
	 *
	 * Si la page est appelé en GET elle affiche la vue consulter.phtml.
	 * Si c'est une requête AJAX, elle prend en paramètre les conditions 
	 * renvoyées par le widget Datatable et précisés au moment de 
	 * l'instanciation du widget. Ces paramètres sont ensuite envoyé à la classe
	 * Datatable qui se charge de renvoyer les données récupérées en 
	 * base de donnée. Ces données sont ensuite passées à la Datatable qui 
	 * se chargera de les afficher.
	 *
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');

        if ($this->getRequest()->isXmlHttpRequest()) {
            $params = $this->params()->fromQuery();
    
            $entityManager = $this->getEntityManager()
                ->getRepository('Collection\Entity\Select');
        
            $dataTable = new \Admin\Model\LogsDataTable($params);
            $dataTable->setEntityManager($entityManager);
            
            $dataTable->setConfiguration(array(
	    		'label',
		        'description',
            ));

            $aaData = array();

            foreach ($dataTable->getPaginator() as $select) {

            	$apercu = '<select class="select2">';
			    foreach ($select->select_values as $select_value) {
			    	$apercu .= '<option value="'.$select_value->id.'">'.$select_value->text.'</option>';
			    }
			    $apercu .= '</select>';


                $action = '<a href="#" 
	            			data-url="'.$this->url()->fromRoute("champSelect/modifierValueAjax", array("id" => $select->id)).'" 
	            			class="btn btn-primary modifierValue"
	            			data-toggle="popover"
	            			data-content="Ajouter / Modifier une valeur">
	            				<i class="icon-folder-open-alt"></i>
	            			</a>';


                $aaData[] = array(
                	'<span id="label" 
                        class="text CursorPointer" 
                        data-url="'.$this->url()->fromRoute("champSelect/modifier", array("id" => $select->id)).'" 
                        data-value="'.$escapeHtml($select->label).'" data-placement="right" data-type="text" data-pk="1">'.$escapeHtml($select->label).'
                    </span>',
                    '<span id="description" 
                        class="text CursorPointer" 
                        data-url="'.$this->url()->fromRoute("champSelect/modifier", array("id" => $select->id)).'" 
                        data-value="'.$escapeHtml($select->description).'" data-placement="right" data-type="textarea" data-pk="1">'.$escapeHtml($select->description).'
                    </span>',
                    $apercu,
	    			$action
                );
            }
            $dataTable->setAaData($aaData);
            
            return $this->getResponse()->setContent($dataTable->findAll());
        } else {
            return new ViewModel();

        }
    }

    /**
	 * 
	 *
	 * 
	 *
     * @return \Zend\View\Model\ViewModel
     */
    public function ajouterAction()
    {


    }

    /**
	 * 
	 *
	 * 
	 *
     * @return \Zend\View\Model\ViewModel
     */
    public function modifierAction()
    {


    }

    /**
	 * 
	 *
	 * 
	 *
     * @return \Zend\View\Model\ViewModel
     */
    public function modifierValueAjaxAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');

    	$id = (int) $this->params('id', null);
		$select = $this->getEntityManager()->getRepository('Collection\Entity\Select')->findOneBy(array('id'=>$id));
		if ($select == null or $id == null) {
			$this->getResponse()->setStatusCode(404);
			return; 
		}

        $postData = $this->params()->fromPost();
		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			switch ($postData['name']) {
				case 'voirListe':
					$viewModel = new ViewModel(array('select' => $select));
                    $viewModel->setTerminal(true);
                    return $viewModel->setTemplate('Collection/Champ-Select/modifierValueAjax.phtml');
					break;

				case 'modifierTexte':
					$idValue = (int) $this->params('idValue', null);
					$selectValue = $this->getEntityManager()->getRepository('Collection\Entity\SelectValue')->findOneBy(array('id'=>$idValue));
					if ($selectValue == null or $id == null) {
						$this->getResponse()->setStatusCode(404);
						return; 
					}

					$selectValue->text = $postData['value'];
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
					break;
				case 'supprimerValue':
					$idValue = (int) $this->params('idValue', null);
					$selectValue = $this->getEntityManager()->getRepository('Collection\Entity\SelectValue')->findOneBy(array('id'=>$idValue));
					if ($selectValue == null or $id == null) {
						$this->getResponse()->setStatusCode(404);
						return; 
					}
					// si la value du select n'est pas utilisé dans un element alors on a supprime
					if ($selectValue->datas == null) {
	                    $this->getEntityManager()->remove($selectValue);
	                    $this->getEntityManager()->flush();
	                    return $this->getResponse()->setContent(Json::encode(array('message'=>'ok')));
					}
	                return $this->getResponse()->setContent(Json::encode(array('message'=>$selectValue->datas)));
					break;
				
				default:
					$this->getResponse()->setStatusCode(404);
					return; 
					break;
			}


		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
    }


    
}
