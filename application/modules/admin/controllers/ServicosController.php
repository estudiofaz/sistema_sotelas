<?php

class Admin_ServicosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$read = Zend_Auth::getInstance()->getStorage()->read();
    	
       	if ($read->perfilLogin == 0){
    		$this->view->read = $read;
    	
    	}elseif ($read->perfilLogin == 1){
    		$this->_redirect("/cliente/index");
    	
    	}else{
    		$this->_redirect("/default/index/msg/3");
    	}
    	
    }

    public function indexAction()
    {
        // action body
    		$msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Serviço adicionado com sucesso.
	        		</div>";
    		$this->view->alert = $alert;
    		
    	}elseif($msg == 2){
	        $alert = "<div class='alert alert-error'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Houve um erro. Tente novamente.
	        		</div>";
    		$this->view->alert = $alert;
    		
    	}elseif($msg == 3){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Alterações efetuadas com sucesso.
	        		</div>";
    		$this->view->alert = $alert;

    	}elseif($msg == 4){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Serviço excluído com sucesso.
	        		</div>";
    		$this->view->alert = $alert;    		
    		
    	}else{
    		$alert = null;
    	}
    	
        $modelCategoria = new Admin_Model_DbTable_Servicocategoria();
        $sqlCategoria = $modelCategoria->select()->order('categoriaServico ASC');
        $categorias = $modelCategoria->getAdapter()->fetchAll($sqlCategoria);
        $this->view->categorias = $categorias;
    	
    }

    
    public function viewAction(){
    	
    		$msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Serviço adicionado com sucesso.
	        		</div>";
    		$this->view->alert = $alert;
    		
    	}elseif($msg == 2){
	        $alert = "<div class='alert alert-error'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Houve um erro. Tente novamente.
	        		</div>";
    		$this->view->alert = $alert;
    		
    	}elseif($msg == 3){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Alterações efetuadas com sucesso.
	        		</div>";
    		$this->view->alert = $alert;

    	}elseif($msg == 4){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Serviço excluído com sucesso.
	        		</div>";
    		$this->view->alert = $alert;    		
    		
    	}else{
    		$alert = null;
    	}
    	
    	$id = $this->_getParam('id', 0);
    	
        $modelCategoria = new Admin_Model_DbTable_Servicocategoria();
        $sqlCategoria = $modelCategoria->select()
        										->where('id = ?', $id);
        $categoria = $modelCategoria->getAdapter()->fetchRow($sqlCategoria);
        $this->view->categoria = $categoria;
    	
    	
    	$modelServico = new Admin_Model_DbTable_Servico();
    	$sqlServico = $modelServico->select()
    										->where('categoria_idServicoCategoria = ?', $id)
    										->order('tituloServico ASC');
    	$servicos = $modelServico->getAdapter()->fetchAll($sqlServico);
    	$this->view->servicos = $servicos;
    	
    	
    }
    
    
    public function addAction()
    {
        // action body
        
       	// CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Adicionar'){
				
				$id = $this->_getParam('id', 0);
				
				$tituloServico	= $this->getRequest()->getPost('tituloServico');
				$descServico	= $this->getRequest()->getPost('descServico');
		
				//DEFINE DESTINO
				$dir = 'upload/servicos';
				$upload->setDestination('upload/servicos');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Servico();

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
										'tituloServico'		=> 	$tituloServico,
										'descServico'		=> 	$descServico,
										'categoria_idServicoCategoria' => $id,
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome
										);
							//$where = $modelUpload->getAdapter()->quoteInto('idProduto = 1');		
							//$modelUpload->update($data, $where);
							$modelUpload->insert($data);
							
							$this->_redirect('/admin/servicos/view/id/'.$id.'/msg/1');
								
						}else{
							$this->_redirect('/admin/servicos/index/msg/2');
						}
					}else{
						
						$data = array(
									'tituloServico'		=> $tituloServico,
									'descServico'		=> 	$descServico,
									'categoria_idServicoCategoria' => $id,
									);
						
						$modelUpload->insert($data);
						
						$this->_redirect('/admin/servicos/view/id/'.$id.'/msg/1');
					}
			
					endforeach;
					
				}else{
						$data = array(
									'tituloServico'		=> $tituloServico,
									'descServico'		=> 	$descServico,
									'categoria_idServicoCategoria' => $id,
									);
						
						$modelUpload->insert($data);
					
					$this->_redirect('/admin/servicos/view/id/'.$id.'/msg/1');
				}
				
				$this->_redirect('/admin/servicos/view/id/'.$id.'/msg/2');
			}
		}
    	
    }
    

    public function editAction()
    {
        // action body
        $id = $this->_getParam('id', 0);
    	
        $id_servicoCategoria = $this->getRequest()->getPost('id_servicoCategoria');
        
		$modelServico = new Admin_Model_DbTable_Servico();
    	$sqlServico = $modelServico->select()->where('idServico = ?', $id);
    	$servico = $modelServico->getAdapter()->fetchRow($sqlServico);
    	$this->view->servico = $servico;
    	
		// CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Confirmar'){
								
				$tituloServico	= $this->getRequest()->getPost('tituloServico');
				$descServico	= $this->getRequest()->getPost('descServico');
				
		
				//DEFINE DESTINO
				$dir = 'upload/servicos';
				$upload->setDestination('upload/servicos');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Servico();

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
										'tituloServico'		=> 	$tituloServico,
										'descServico'		=> 	$descServico,
										'categoria_idServicoCategoria' => $id_servicoCategoria,
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome
										);
							$where = $modelUpload->getAdapter()->quoteInto('idServico = '.(int)$id);		
							$modelUpload->update($data, $where);
							//$modelUpload->insert($data);
							
							$this->_redirect('/admin/servicos/view/id/'.$id_servicoCategoria.'/msg/3');
								
						}else{
							$this->_redirect('/admin/servicos/view/id/'.$id_servicoCategoria.'/msg/2');
						}
					}else{
						
						$data = array(
									'tituloServico'		=> $tituloServico,
									'descServico'		=> 	$descServico,
									'categoria_idServicoCategoria' => $id_servicoCategoria
									);
						
						$where = $modelUpload->getAdapter()->quoteInto('idServico = '.(int)$id);		
						$modelUpload->update($data, $where);
						
						$this->_redirect('/admin/servicos/view/id/'.$id_servicoCategoria.'/msg/3');
					}
			
					endforeach;
					
				}else{
						$data = array(
									'tituloServico'		=> $tituloServico,
									'descServico'		=> 	$descServico,
									'categoria_idServicoCategoria' => $id_servicoCategoria
									);
						
						$where = $modelUpload->getAdapter()->quoteInto('idServico = '.(int)$id);		
						$modelUpload->update($data, $where);
					
					$this->_redirect('/admin/servicos/view/id/'.$id_servicoCategoria.'/msg/3');
				}
				
				$this->_redirect('/admin/servicos/view/id/'.$id_servicoCategoria.'/msg/2');
			}
		}
    	
    }

    public function delAction()
    {
        // action body
        $this->_helper->layout->setLayout('del');
    	
        $id = $this->_getParam('id', 0);
    	
		$modelServico = new Admin_Model_DbTable_Servico();
    	$sqlServico = $modelServico->select()->where('idServico = ?', $id);
    	$servico = $modelServico->getAdapter()->fetchRow($sqlServico);
    	$this->view->servico = $servico;
    	
    	
       	if($this->getRequest()->isPost()){
		$del = $this->getRequest()->getPost('up');
			if($del == 'Excluir'){
				
				$nomeArquivo = $this->getRequest()->getPost('nomeArquivo');
 
				$upload = new Admin_Model_DbTable_Servico();
					
				// EXCLUIR ARQUIVOS E A PASTA DE UPLOADS DA OBRA
				$roodDir = 'upload/servicos';
				$this->removeArquivo($rootDir, $nomeArquivo);
					
				// REMOVE UPLOAD DO BANCO DE DADOS
				$upload->delete('idServico = '.(int)$id);
				
				$this->_redirect('/admin/servicos/index/msg/4');
			
			}elseif ($del == 'Cancelar'){
				
				$this->_redirect('/admin/servicos');
			}
		
			$this->_redirect('/admin/servicos');
       	}
       	
    }

    public function removeArquivo($rootDir, $nomeArquivo)
    {
		if (!is_dir($rootDir))
		{
			return false;
		}

		if (!preg_match("/\/$/", $rootDir))
		{
			$rootDir .= '/';
		}

		$dh     = opendir($rootDir);

		while (($file = readdir($dh)) !== false)
		{
			if ($file == '.'  ||  $file == '..')
			{
				continue;
			}

			if (is_dir($rootDir . $file))
			{
				$hasDir = true;
				array_push($stack, $rootDir . $file . '/');
			}

			else if (is_file($rootDir . $file))
			{
				if($file == $nomeArquivo){
					unlink($rootDir . $nomeArquivo);
					closedir($dh);
				}
			}
		}

		return true;
    }

    

    

}







