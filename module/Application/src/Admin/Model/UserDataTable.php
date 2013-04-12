<?php
namespace Admin\Model;

use DataTable\Model\DataTable;

/**
 * UserDataTable
 *
 * Classe responsável por fazer com que seja possível trabalhar com o plugin 
 * DataTables junto com o ORM Doctrine para efetuar paginações.
 *
 * Neste caso, utilizando as regras específicas para a entidade Product.
 *
 * @author  Thiago Pelizoni <thiago.pelizoni@gmail.com>
 */
class UserDataTable extends DataTable
{
	public function findAll()
	{
	    if (! $this->getConfiguration()) {
	        // Este array deve ser na ordem das colunas da listagem
	        $configuration = array(
	            'id',
	            'username',
	            'displayName',
	            'email',
	        );
	        $this->setConfiguration($configuration);
        }	        
	    
	    /**
	     * Irá montar os dados que serão exibidos no DataTable
	     *
	     * Neste tutorial, a sequencia da listagem está sendo: 'id', 'name', 'description'.
	     * Desta forma, o array que será atribuido a variável DataTable::aaData deve estar
	     * na mesma sequencia.
	     */ 
		if (! $this->getAaData()) {
		    $aaData = array();
		    
		    foreach ($this->getPaginator() as $user) {
			    $data = array(
				    $user->id,
				    $user->username,
				    $user->displayName,
				    $user->email,
				    '<a href="#" class="status" data-type="select" data-pk="1" data-url="/post" data-original-title="Select status">dd</a>
'
				    ,
			    );
			
			    $aaData[] = $data;
		    }
		
		    $this->setAaData($aaData);
		}
		
		return $this->getJson();
	}
	    
}
