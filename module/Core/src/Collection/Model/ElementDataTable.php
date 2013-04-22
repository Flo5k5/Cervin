<?php
namespace Collection\Model;

use DataTable\Model\DataTable;

class ElementDataTable extends DataTable
{
	public function findAll()
	{
	    if (! $this->getConfiguration()) {
	        $configuration = array(
	            'titre',
	            'description'
	        );
	        $this->setConfiguration($configuration);
        }	        
		if (! $this->getAaData()) {
		    $aaData = array();
		    foreach ($this->getPaginator() as $element) {
			    $data = array(
                    $element->titre,
                    $element->description,
			    );
			    $aaData[] = $data;
		    }
		    $this->setAaData($aaData);
		}
		return $this->getJson();
	}
	
}
