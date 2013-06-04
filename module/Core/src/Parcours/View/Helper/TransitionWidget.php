<?php
namespace Parcours\View\Helper;

use Zend\ServiceManager\ServiceManager;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

/**
 * Widget permettant d'afficher une transition
 * sur la page de visualisation d'un parcours
 */
class TransitionWidget extends AbstractHelper
{
	
    /**
     * Fonction executée lors de l'appel du widget
     * 
     * @param \Parcours\Entity\Transition $transition
     */
    public function __invoke($transition = null)
    {
    	return $this->getView()->partial( 'Parcours/Parcours/transition-widget.phtml', array(  
	    	'transition' => $transition, 
	    ));
    }
}
