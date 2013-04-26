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
				
				//Tableau de types autorisés
				$allowedType = array("type", "titre", "description", "id");

				$arrayOfType = array();

				//On traite les éléments passés en POST
				foreach ($conditions as $condition) {
					//Vérifie que le type est bien autorisé
					if(in_array($condition["type"], $allowedType)) {
						//On ajoute le type dans le tableau et on ajoute la valeur dans un sous tableau
						$arrayOfType[$condition["type"]][] = $condition["value"];
					}
					
				}

				$andX = $query->expr()->andX();

				//On traite chaque type
				foreach($arrayOfType as $key => $type){

					$requete = "eq";
					
					if( $key === "type" || $key === "id" ){
						$key = $alias_type.'.'.$key;
					} else if( $key === "titre" ){
						$key = $alias.'.'.$key;
						$requete = "like";
					} else {
						$key = $alias.'.'.$key;
					}

					//Si il y a plus de 1 valeur pour un type, on les ajoute au tableau de OR
					if( count($type) > 1 ){
						
						$orX = $query->expr()->orX();
						
						foreach($type as $value){
							if($requete === "like"){ $value = '%'.$value.'%'; }
							
							$orX->add($query->expr()->$requete( $key,  $query->expr()->literal($value) ));
						}
						
						$andX->add($orX);
						
					//Sinon on les ajoute au tableau de AND
					} else {
						if($requete === "like"){ $type[0] = '%'.$type[0].'%'; }
						
						$andX->add($query->expr()->$requete( $key,  $query->expr()->literal($type[0]) ));
						
					}
				}

				$query->add('where', $andX);

			}

			$query
			->setFirstResult($this->getPage())
			->setMaxResults($this->getDisplayLength());
			//->orderBy("{$alias}.{$this->configuration[$this->iSortCol_0]}",  $this->sSortDir_0);
	
			//var_dump($query->getQuery()->getSQL());
			
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
