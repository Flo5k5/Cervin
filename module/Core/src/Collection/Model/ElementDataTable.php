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
		//var_dump($obj["aaData"]);
		return json_encode($obj["aaData"]);
	}

	public function getPaginator($conditions = null)
	{
		if (! $this->paginator) {
			$entityManager = $this->getEntityManager();
	
			$alias = 'entity';
			$alias_type = 't';
				
			$query = $entityManager->createQueryBuilder($alias);
	
			if(isset($conditions)){
				$andX = $query->expr()->andX();
				 
				foreach ($conditions as $key => $value) {
					if($key != 'type'){
						$key = $alias.'.'.$key;
					} else {
						$key = $alias_type.'.'.$key;
					}
	
					if($key !=  $alias.'.titre'){
						$andX->add($query->expr()->eq( $key,  $query->expr()->literal($value) ));
					} else {
						$andX->add($query->expr()->like( $key,  $query->expr()->literal($value) ));
					}
				}
	
				$query
				->leftJoin($alias.'.type_element', $alias_type)
				->addSelect($alias_type)
				->add('where', $andX);
			}
	
			$query
			->setFirstResult($this->getPage())
			->setMaxResults($this->getDisplayLength())
			->orderBy("{$alias}.{$this->configuration[$this->iSortCol_0]}",  $this->sSortDir_0);
	
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
