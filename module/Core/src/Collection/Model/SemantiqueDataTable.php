<?php
namespace Collection\Model;

use DataTable\Model\DataTable;

class SemantiqueDataTable extends DataTable
{
	public function findAll()
	{
	    if (! $this->getConfiguration()) {
	        $configuration = array(
	            'Type origine',
	            'S�mantique',
	            'Type destination'
	        );
	        $this->setConfiguration($configuration);
        }	        
		if (! $this->getAaData()) {
		    $aaData = array();
		    foreach ($this->getPaginator() as $semantique) {
			    $data = array(
                    $semantique->type_origine,
                    $semantique->semantique,
                    $semantique->type_destination
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
				
			$query = $entityManager->createQueryBuilder($alias)
			                       /*->leftJoin($alias.'.type_element', $alias_type)
			                       ->addSelect($alias_type)*/;

			if(isset($conditions)){
				
				//Tableau de types autoris�s
				$allowedType = array("type_origine", "semantique", "type_destination");

				$arrayOfType = array();

				//On traite les �l�ments pass�s en POST
				foreach ($conditions as $condition) {
					//V�rifie que le type est bien autoris�
					if(in_array($condition["type"], $allowedType)) {
						//On ajoute le type dans le tableau et on ajoute la valeur dans un sous tableau
						$arrayOfType[$condition["type"]][] = $condition["value"];
					}
					
				}

				$andX = $query->expr()->andX();

				//On traite chaque type
				foreach($arrayOfType as $key => $type){

					$requete = "eq";
					
					if( $key === "semantique" ){
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
			//->orderBy("{$alias}.{$this->configuration[$this->iSortCol_0]}",  $this->sSortDir_0)
		    //->addOrderBy("{$alias}.{$this->configuration[$this->iSortCol_0]}",  strtoupper($this->sSortDir_0))
			//->add("orderBy", "{$alias}.{$this->configuration[$iSortCol_0]} {$this->sSortDir_0}")
			->setFirstResult($this->getPage())
			->setMaxResults($this->getDisplayLength());

			$iSortCol_0 = !isset($this->iSortCol_0) ? 0 : $this->iSortCol_0;

			$query->add("orderBy", "{$alias}.{$this->configuration[$iSortCol_0]} {$this->sSortDir_0}");


			if ($this->getSSearch() != null) {
				$sSearch = strtoupper($this->getSSearch());
				$sSearch = preg_replace('/[^[:ascii:]]/', '%', $sSearch);
				$sSearch = preg_replace('/[%]{1,}/', '%', $sSearch);
				$sSearch = '%'.$sSearch.'%';

				$this->setSSearch($sSearch);
				
				$andX = $query->expr()->andX();
				
				$orX = $query->expr()->orX();
				
				//for ($i = 0; $i < 2; $i++) {

					$column = $this->configuration[1];
					
					$orX->add($query->expr()->like( $query->expr()->upper("{$alias}.{$column}"), $query->expr()->literal($this->getSSearch()) ));

				//}
				
				$andX->add($orX);
				
				//$query->add('where', $andX);
				$query->andWhere($andX);
			}
			
			//var_dump($query->getQuery()->getSQL());
			
			$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);

			$this->setTotalRecords($paginator->count());
			$this->setTotalDisplayRecords($paginator->count());
	
			$this->paginator = $paginator;
		}
	
		return $this->paginator;
	}

	
	/**
	 * Cr�dit : http://www.ycerdan.fr/php/tronquer-un-texte-en-conservant-les-tags-html-en-php/
	 * 
	 * Truncates text.
	 *
	 * Cuts a string to the length of $length and replaces the last characters
	 * with the ending if the text is longer than length.
	 *
	 * @param string  $text String to truncate.
	 * @param integer $length Length of returned string, including ellipsis.
	 * @param mixed $ending If string, will be used as Ending and appended to the trimmed string. Can also be an associative array that can contain the last three params of this method.
	 * @param boolean $exact If false, $text will not be cut mid-word
	 * @param boolean $considerHtml If true, HTML tags would be handled correctly
	 * @return string Trimmed string.
	 */
	public function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
		if (is_array($ending)) {
			extract($ending);
		}
		if ($considerHtml) {
			if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			$totalLength = mb_strlen($ending);
			$openTags = array();
			$truncate = '';
			preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
			foreach ($tags as $tag) {
				if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
					if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
						array_unshift($openTags, $tag[2]);
					} else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
						$pos = array_search($closeTag[1], $openTags);
						if ($pos !== false) {
							array_splice($openTags, $pos, 1);
						}
					}
				}
				$truncate .= $tag[1];
	
				$contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
				if ($contentLength + $totalLength > $length) {
					$left = $length - $totalLength;
					$entitiesLength = 0;
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
						foreach ($entities[0] as $entity) {
							if ($entity[1] + 1 - $entitiesLength <= $left) {
								$left--;
								$entitiesLength += mb_strlen($entity[0]);
							} else {
								break;
							}
						}
					}
	
					$truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
					break;
				} else {
					$truncate .= $tag[3];
					$totalLength += $contentLength;
				}
				if ($totalLength >= $length) {
					break;
				}
			}
	
		} else {
			if (mb_strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = mb_substr($text, 0, $length - strlen($ending));
			}
		}
		
		if (!$exact) {
			$spacepos = mb_strrpos($truncate, ' ');
			if (isset($spacepos)) {
				if ($considerHtml) {
					$bits = mb_substr($truncate, $spacepos);
					preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
					if (!empty($droppedTags)) {
						foreach ($droppedTags as $closingTag) {
							if (!in_array($closingTag[1], $openTags)) {
								array_unshift($openTags, $closingTag[1]);
							}
						}
					}
				}
				$truncate = mb_substr($truncate, 0, $spacepos);
			}
		}
	
		$truncate .= $ending;
	
		if ($considerHtml) {
			foreach ($openTags as $tag) {
				$truncate .= '</'.$tag.'>';
			}
		}
	
		return $truncate;
	}
	
}