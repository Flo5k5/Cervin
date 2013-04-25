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
	
	public function getJSONaaData(){
		$obj = get_object_vars($this);
		return json_encode($obj["aaData"]);
	}

	public function getPaginator($conditions = null)
	{
		if (! $this->paginator) {
			$entityManager = $this->getEntityManager();
	
			$alias = 'entity';
			$alias_type = 't';
				
			$query = $entityManager->createQueryBuilder($alias)
			                       ->leftJoin($alias.'.type_element', $alias_type)
			                       ->addSelect($alias_type);
	
			if(isset($conditions)){

				$arrayOfType = array();
				$arrayOfAndX = array();

				foreach ($conditions as $condition) {
					
					if($condition["type"] === 'type'){
						$arrayOfType[] = array( 
												'type'  => $alias_type.'.type',
								                'value' => $condition["value"]
										);
					} else {
						$arrayOfAndX[] = array( 
												'type'  => $alias.'.'.$condition["type"],
								                'value' => $condition["value"]
										);
					}

				}
				
				if( count($arrayOfType) > 1 ){
					$orX = $query->expr()->orX();
					
					foreach ($arrayOfType as $element) {
						$orX->add($query->expr()->eq( $element["type"],  $query->expr()->literal($element["value"]) ));
					}
					
					$query->add('where', $orX);
				}
				
				if( count($arrayOfAndX) > 0 && count($arrayOfType) === 1 ){
					$andX = $query->expr()->andX();

					foreach ($arrayOfAndX as $element) {
						if($element["type"] ===  $alias.'.titre'){
							$element["value"] = '%'.$element["value"].'%';
							$andX->add($query->expr()->like( $element["type"],  $query->expr()->literal($element["value"]) ));
						} else {
							$andX->add($query->expr()->eq( $element["type"],  $query->expr()->literal($element["value"]) ));
						}
					}
					
					$andX->add($query->expr()->eq( $arrayOfType[0]["type"],  $query->expr()->literal($arrayOfType[0]["value"]) ));
					
					$query->add('where', $andX);
				}
				
				if( count($arrayOfAndX) === 0 && count($arrayOfType) === 1 ){
					$andX = $query->expr()->andX();
					$andX->add($query->expr()->eq( $arrayOfType[0]["type"],  $query->expr()->literal($arrayOfType[0]["value"]) ));
					$query->add('where', $andX);
				}
				
				if( count($arrayOfAndX) > 0 && count($arrayOfType) === 0){
					$andX = $query->expr()->andX();
				
					foreach ($arrayOfAndX as $element) {
						if($element["type"] ===  $alias.'.titre'){
							$element["value"] = '%'.$element["value"].'%';
							$andX->add($query->expr()->like( $element["type"],  $query->expr()->literal($element["value"]) ));
						} else {
							$andX->add($query->expr()->eq( $element["type"],  $query->expr()->literal($element["value"]) ));
						}
					}

					$query->add('where', $andX);
				}
			}
	
			$query
			->setFirstResult($this->getPage())
			->setMaxResults($this->getDisplayLength());
			//->orderBy("{$alias}.{$this->configuration[$this->iSortCol_0]}",  $this->sSortDir_0);
	
			if ($this->getSSearch() != null) {
				$sSearch = strtoupper($this->getSSearch());
				$sSearch = preg_replace('/[^[:ascii:]]/', '%', $sSearch);
				$sSearch = preg_replace('/[%]{1,}/', '%', $sSearch);
				$this->setSSearch($sSearch);
				 
				foreach ($this->getConfiguration() as $column) {
					$query->orWhere("UPPER({$alias}.{$column}) LIKE '%{$this->getSSearch()}%'");
				}
			}
	
			$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
	
			$this->setTotalRecords($paginator->count());
			$this->setTotalDisplayRecords($paginator->count());
	
			$this->paginator = $paginator;
		}
	
		return $this->paginator;
	}
	
	
	
}
