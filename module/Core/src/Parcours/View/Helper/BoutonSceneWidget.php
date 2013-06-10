<?php
namespace Parcours\View\Helper;

use Zend\ServiceManager\ServiceManager;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

/**
 * Widget permettant d'afficher le bouton représentant une scène
 * sur la page de visualisation d'un parcours
 */
class BoutonSceneWidget extends AbstractHelper
{
	
    /**
     * Fonction executée lors de l'appel du widget
     * 
     * @param \Parcours\Entity\Scene $scene
     */
    public function __invoke($scene = null)
    {
    	return $this->getView()->partial( 'Parcours/Parcours/bouton-scene-widget.phtml', array(  
	    	'scene' => $scene, 
	    ));
    }
}
