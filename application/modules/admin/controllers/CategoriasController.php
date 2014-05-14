<?php

class Admin_CategoriasController extends Zend_Controller_Action
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
        $modelCategoria = new Admin_Model_DbTable_Categoria();
        $sqlCategoria = $modelCategoria->select()
                                                ->where('perfilCategoria = 0')
                                                ->order('descCategoria ASC');
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
        
    	
		// CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Salvar'){
								
				$id				= $this->getRequest()->getPost('idCategoria');
				$descCategoria	= $this->getRequest()->getPost('descCategoria');							
		
				//DEFINE DESTINO
				$dir = 'upload\categorias';
				$upload->setDestination('upload\categorias');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Categoria();

				if ($files != null){
					//FAZ LAÇO PARA INSERIR OS ARQUIVOS
					foreach ($files as $file => $info):
			
					if($upload->isValid($file)){
			
						if($upload->receive($file)){
			
							//$ext = explode('/', $upload->getMimeType($file));
							$ext = explode('.', $upload->getFileName($file));
							$ext = $ext[1];
								
							// nome do arquivo
							$nomeArquivo = md5(uniqid()).'.'.$ext;
								
							$filePath = $upload->getDestination($file);
							$filterFileRename = new Zend_Filter_File_Rename(array('target' => $filePath.'/'.$nomeArquivo, 'overwrite' => true));
							$filterFileRename->filter($upload->getFileName($file));
								
							// FIM RENAME DO ARQUIVO
								
							$nome = $upload->getFileName($file);
							$exp = explode($dir, $nome);
			
							$nome = $exp[1];
								
						$data = array(
										'descCategoria'	=>	$descCategoria,
										'nomeArquivo'	=> 	$nomeArquivo,
										'fotoGaleria'	=>	$nome,
						                 
										);
										
							$where = $modelUpload->getAdapter()->quoteInto('idCategoria = '.(int)$id);		
							$modelUpload->update($data, $where);
							//$modelUpload->insert($data);
							
							$this->_redirect('/admin/categorias/index/msg/2');
							
								
						}else{
							$this->_redirect('/admin/categorias/index/msg/3');
							
						}
					}else{
						
						$data = array('descCategoria'	=>	$descCategoria);
						
						$where = $modelUpload->getAdapter()->quoteInto('idCategoria = '.(int)$id);
						$modelUpload->update($data, $where);
						//$modelUpload->insert($data);
						
						$this->_redirect('/admin/categorias/index/msg/2');
					}
			
					endforeach;
					
				}else{

					$data = array('descCategoria'	=>	$descCategoria);
					
					$where = $modelUpload->getAdapter()->quoteInto('idCategoria = '.(int)$id);
					$modelUpload->update($data, $where);
					//$modelUpload->insert($data);
					
					$this->_redirect('/admin/categorias/index/msg/2');
				}
				
				$this->_redirect('/admin/categorias/index/msg/3');;
			}
		}
		
    }

    public function addAction()
    {
        // action body
		// CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Adicionar'){
								
				$descCategoria	= $this->getRequest()->getPost('descCategoria');
							
		
				//DEFINE DESTINO
				$dir = 'upload/categorias';
				$upload->setDestination('upload/categorias');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Categoria();

				if ($files != null){
					//FAZ LAÇO PARA INSERIR OS ARQUIVOS
					foreach ($files as $file => $info):
			
					if($upload->isValid($file)){
			
						if($upload->receive($file)){
			
							//$ext = explode('/', $upload->getMimeType($file));
							$ext = explode('.', $upload->getFileName($file));
							$ext = $ext[1];
								
							// nome do arquivo
							$nomeArquivo = md5(uniqid()).'.'.$ext;
								
							$filePath = $upload->getDestination($file);
							$filterFileRename = new Zend_Filter_File_Rename(array('target' => $filePath.'/'.$nomeArquivo, 'overwrite' => true));
							$filterFileRename->filter($upload->getFileName($file));
								
							// FIM RENAME DO ARQUIVO
								
							$nome = $upload->getFileName($file);
							$exp = explode($dir, $nome);
			
							$nome = $exp[1];
								
						$data = array(	'descCategoria'		=>	$descCategoria,
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome ,
						                'perfilCategoria'   =>  0);
										
							//$where = $modelUpload->getAdapter()->quoteInto('idLoja = 1');		
							//$modelUpload->update($data, $where);
							
						//print_r($data); die;
							$modelUpload->insert($data);
							
							$this->_redirect('/admin/categorias/index/msg/1');
								
						}else{
							$this->_redirect('/admin/categorias/index/msg/3');
						}
					}else{
						
						$data = array('descCategoria'		=>	$descCategoria);
						
						//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
						//$modelUpload->update($data, $where);
						$modelUpload->insert($data);
						
						$this->_redirect('/admin/categorias/index/msg/1');
					}
			
					endforeach;
					
				}else{

					$data = array('descCategoria'		=>	$descCategoria);
					
					//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
					//$modelUpload->update($data, $where);
					$modelUpload->insert($data);
					
					$this->_redirect('/admin/categorias/index/msg/1');
				}
				
				$this->_redirect('/admin/categorias/index/msg/3');;
			}
		}
    	
    }

    public function delAction()
    {
        // action body
    	$this->_helper->layout->setLayout('del');
		
		$id = $this->_getParam('id', 0);
       
		$modelCategoria = new Admin_Model_DbTable_Categoria();
		$sqlCategoria = $modelCategoria->select()->where('idCategoria = ?', $id);
		$categoria = $modelCategoria->getAdapter()->fetchRow($sqlCategoria);
		$this->view->categoria = $categoria;

    	
		if($this->getRequest()->isPost()){
		$del = $this->getRequest()->getPost('up');
			if($del == 'Excluir'){
				
				$modelCategoria->delete('idCategoria = '.(int)$id);
				
				$this->_redirect('/admin/categorias/index/msg/4');
			
			}elseif ($del == 'Cancelar'){
				
				$this->_redirect('/admin/categorias/index');
			}
			
			$this->_redirect('/admin/categorias/index');
			
       	}
    }


}





