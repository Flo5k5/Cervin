<?php
namespace Parcours\View\Helper;

use Zend\ServiceManager\ServiceManager;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

/**
 * Widget permettant d'afficher le titre d'un sous-parcours
 * sur la page de visualisation d'un parcours
 */
class TitreSousParcoursWidget extends AbstractHelper
{
	
    /**
     * Fonction executée lors de l'appel du widget
     * 
     * @param \Parcours\Entity\SousParcours $sous_parcours
     */
    public function __invoke($sous_parcours = null)
    {
    	return $this->getView()->partial( 'Parcours/Parcours/titre-sous-parcours-widget.phtml', array(  
	    	'sous_parcours' => $sous_parcours, 
	    ));
    }
}
