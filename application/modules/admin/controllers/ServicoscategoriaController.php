<?php

class Admin_ServicoscategoriaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$read = Zend_Auth::getInstance()->getStorage()->read();
    	$this->view->read = $read;
    	
    }

    public function indexAction()
    {
        // action body
        $modelCategoria = new Admin_Model_DbTable_Servicocategoria();
        $sqlCategoria = $modelCategoria->select()->order('categoriaServico ASC');
        $categorias = $modelCategoria->getAdapter()->fetchAll($sqlCategoria);
        $this->view->categorias = $categorias;
        
        
    	$msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Categoria adicionada com sucesso.
	        		</div>";
    		$this->view->alert = $alert;
    		
    	}elseif($msg == 2){	
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Suas alterações foram efetuadas com sucesso.
	        		</div>";
    		$this->view->alert = $alert;
    		
    	}elseif($msg == 3){
	        $alert = "<div class='alert alert-error'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Houve um erro. Tente novamente.
	        		</div>";
    		$this->view->alert = $alert;
    		
    	}elseif($msg == 4){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Categoria removida com sucesso.
	        		</div>";
    		$this->view->alert = $alert;
    	}else{
    		$alert = null;
    	}
    }
    
   public function editAction(){
    	
    	$id = $this->_getParam('id', 0); 
    	
        $modelCategoria = new Admin_Model_DbTable_Servicocategoria();
        $sqlCategoria = $modelCategoria->select()->where("id = ?", $id);
        $categoria = $modelCategoria->getAdapter()->fetchRow($sqlCategoria);
        $this->view->categoria = $categoria;
    	
		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Confirmar'){
				
				$descCategoria	= $this->getRequest()->getPost('categoriaServico');
								
				$data = array('categoriaServico'	=>	$descCategoria);
										
				$where = $modelCategoria->getAdapter()->quoteInto('id = '.(int)$id);		
				$modelCategoria->update($data, $where);
				//$modelUpload->insert($data);
					
				$this->_redirect('/admin/servicoscategoria/index/msg/2');
			}

			$this->_redirect('/admin/servicoscategoria/index/msg/3');;
		}
    	
    	
    }
    
    
    public function addAction()
    {
        // action body

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Adicionar'){
								
				$descCategoria	= $this->getRequest()->getPost('categoriaServico');
							
				$data = array(	'categoriaServico'		=>	$descCategoria);
								
				$modelCategoria = new Admin_Model_DbTable_Servicocategoria();
				//$where = $modelUpload->getAdapter()->quoteInto('idLoja = 1');		
				//$modelUpload->update($data, $where);
				$modelCategoria->insert($data);
				
				$this->_redirect('/admin/servicoscategoria/index/msg/1');
				}
				
				$this->_redirect('/admin/servicoscategoria/index/msg/3');;
			}
    }

    
    public function delAction()
    {
        // action body
    	$this->_helper->layout->setLayout('del');
		
		$id = $this->_getParam('id', 0);
       
		$modelCategoria = new Admin_Model_DbTable_Servicocategoria();
		$sqlCategoria = $modelCategoria->select()->where('id = ?', $id);
		$categoria = $modelCategoria->getAdapter()->fetchRow($sqlCategoria);
		$this->view->categoria = $categoria;
		
    	
		if($this->getRequest()->isPost()){
		$del = $this->getRequest()->getPost('up');
			if($del == 'Excluir'){
				
				// EXCLUINDO SERVICOS
				$modelProdutos = new Admin_Model_DbTable_Servico();
				$modelProdutos->delete('categoria_idServicoCategoria = '.(int)$id);
				
				// CATEGORIAS 
				$modelCategoria->delete('id = '.(int)$id);
				
				$this->_redirect('/admin/servicoscategoria/index/msg/4');
			
			}elseif ($del == 'Cancelar'){
				
				$this->_redirect('/admin/servicoscategoria/index');
			}
			
			$this->_redirect('/admin/servicoscategoria/index');
			
       	}
    }
    

}

