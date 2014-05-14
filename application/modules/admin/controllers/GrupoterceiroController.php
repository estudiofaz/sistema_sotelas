<?php

class Admin_GrupoterceiroController extends Zend_Controller_Action
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
            $modelPrincipal = new Admin_Model_DbTable_Principal();

        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 14');
        $grupo = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo = $grupo;
            
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 15');
        $grupo1 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo1 = $grupo1;
        
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 16');
        $grupo2 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo2 = $grupo2;
        
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 17');
        $grupo3 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo3 = $grupo3;

		$sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 18');
        $grupo4 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo4 = $grupo4;
        
        	

        $msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Suas alterações foram efetuadas com sucesso.
	        		</div>";
    		$this->view->alert = $alert;
    	}elseif($msg == 2){
	        $alert = "<div class='alert alert-error'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Houve um erro. Tente novamente.
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

    
    public function grupoAction()
    {
        // action body
        $modelPrincipal = new Admin_Model_DbTable_Principal();
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 14');
        $principal = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->principal = $principal;
        

    	if($this->getRequest()->isPost()){
		$up = $this->getRequest()->getPost('up');
		
			if($up == 'Salvar'){		
				
				
				$titulo		= $this->getRequest()->getPost('titulo');
				$desc		= $this->getRequest()->getPost('desc');
				
				$modelUpload = new Admin_Model_DbTable_Principal();
						
					$dados = array(
								'tituloPrincipal'	=> $titulo,
								'descPrincipal'		=> $desc
								);
								
					$where = $modelUpload->getAdapter()->quoteInto('idPrincipal= 14');
		        	$modelUpload->update($dados, $where);
			}
    	}	
				$this->_redirect('/admin/grupoterceiro/index/msg/1');
    }

    
    public function group1Action()
    {
        // action body

		//CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up1');
			
			if($up == 'Salvar'){
								
				$titulo = $this->getRequest()->getPost('titulo1');
				$desc1 = $this->getRequest()->getPost('desc1');
				$linkPrincipal1 = $this->getRequest()->getPost('linkPrincipal1');
				$linkExterno	= $this->getRequest()->getPost('linkExterno');
				
		
				//DEFINE DESTINO
				$dir = 'upload/grupo';
				$upload->setDestination('upload/grupo');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Principal();

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
							$titulo = 0;
							$desc1 = 0;
							$linkPrincipal1 = 0;
							$linkExterno =0;	
							$data = array(
										'tituloPrincipal'	=> 	$titulo,
										'descPrincipal'		=>	$desc1,
										'linkPrincipal'		=>  $linkPrincipal1,
										'linkExterno'		=>  $linkExterno,
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome
										);
							$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 15');		
							//$modelUpload->insert($data);
							//print_r($data); die;
							$modelUpload->update($data, $where);
							
							$this->_redirect('/admin/grupoterceiro/index/msg/1');
								
						}else{
							$this->_redirect('/admin/grupoterceiro/index/msg/2');
						}
					}else{
						
						$data = array(
									'tituloPrincipal'	=> 	$titulo,
									'descPrincipal'		=>	$desc1,
									'linkExterno'		=>  $linkExterno,	
									'linkPrincipal'		=> $linkPrincipal1
									);
						$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 15');
						$modelUpload->update($data, $where);
						
						$this->_redirect('/admin/grupoterceiro/index/msg/1');
					}
			
					endforeach;
					
				}else{
					$data = array(
								'tituloPrincipal'	=> 	$titulo,
								'descPrincipal'		=>	$desc1,
								'linkExterno'		=>  $linkExterno,
								'linkPrincipal'		=> $linkPrincipal1
								);
					$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 15');
					$modelUpload->update($data, $where);
					
					$this->_redirect('/admin/grupoterceiro/index/msg/1');
				}
				
				$this->_redirect('/admin/grupoterceiro/index/msg/2');
			}
		}
    }

    public function group2Action()
    {
        // action body
    	// CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up2');
			
			if($up == 'Salvar'){
								
				$titulo = $this->getRequest()->getPost('titulo2');
				$desc2  = $this->getRequest()->getPost('desc2');
				$linkPrincipal2  = $this->getRequest()->getPost('linkPrincipal2');
				$linkExterno	 = $this->getRequest()->getPost('linkExterno');
				
		
				//DEFINE DESTINO
				$dir = 'upload/grupo';
				$upload->setDestination('upload/grupo');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Principal();

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
										'tituloPrincipal'	=> 	$titulo,
										'descPrincipal'		=>	$desc2,
										'linkPrincipal'		=> $linkPrincipal2,
										'linkExterno'		=>  $linkExterno,
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome
										);
							$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 16');		
							//$modelUpload->insert($data);
							$modelUpload->update($data, $where);
							
							$this->_redirect('/admin/grupoterceiro/index/msg/1');
								
						}else{
							$this->_redirect('/admin/grupoterceiro/index/msg/2');
						}
					}else{
						
						$data = array(
									'tituloPrincipal'	=> 	$titulo,
									'descPrincipal'		=>	$desc2,
									'linkPrincipal'		=> $linkPrincipal2,
									'linkExterno'		=>  $linkExterno
									);
						$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 16');
						$modelUpload->update($data, $where);
						
						$this->_redirect('/admin/grupoterceiro/index/msg/1');
					}
			
					endforeach;
					
				}else{
					$data = array(
								'tituloPrincipal'	=> 	$titulo,
								'descPrincipal'		=>	$desc2,
								'linkPrincipal'		=> $linkPrincipal2,
								'linkExterno'		=>  $linkExterno
								);
					$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 16');
					$modelUpload->update($data, $where);
					
					$this->_redirect('/admin/grupoterceiro/index/msg/1');
				}
				
				$this->_redirect('/admin/grupoterceiro/index/msg/2');
			}
		}
    	
    }

    
    public function group3Action()
    {
        // action body
    		//CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up3');
			
			if($up == 'Salvar'){
				
				$titulo = $this->getRequest()->getPost('titulo3');
				$desc3  = $this->getRequest()->getPost('desc3');
				$linkPrincipal3  = $this->getRequest()->getPost('linkPrincipal3');
				$linkExterno 	 = $this->getRequest()->getPost('linkExterno');
				
		
				//DEFINE DESTINO
				$dir = 'upload/grupo';
				$upload->setDestination('upload/grupo');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Principal();

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
										'tituloPrincipal'	=> 	$titulo,
										'descPrincipal'		=>	$desc3,
										'linkPrincipal'		=> 	$linkPrincipal3,
										'linkExterno'		=>  $linkExterno,
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome
										);
							$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 17');		
							//$modelUpload->insert($data);
							$modelUpload->update($data, $where);
							
							$this->_redirect('/admin/grupoterceiro/index/msg/1');
								
						}else{
							$this->_redirect('/admin/grupoterceiro/index/msg/2');
						}
					}else{
						
						$data = array(
									'tituloPrincipal'	=> 	$titulo,
									'descPrincipal'		=>	$desc3,
									'linkPrincipal'		=> 	$linkPrincipal3,
									'linkExterno'		=>  $linkExterno
									);
						$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 17');
						$modelUpload->update($data, $where);
						
						$this->_redirect('/admin/grupoterceiro/index/msg/1');
					}
			
					endforeach;
					
				}else{
					$data = array(
								'tituloPrincipal'	=> 	$titulo,
								'descPrincipal'		=>	$desc3,
								'linkPrincipal'		=> 	$linkPrincipal3,
								'linkExterno'		=>  $linkExterno
								);
					$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 17');
					$modelUpload->update($data, $where);
					
					$this->_redirect('/admin/grupoterceiro/index/msg/1');
				}
				$this->_redirect('/admin/grupoterceiro/index/msg/2');
			}
		}
    }

    
    public function group4Action()
    {
        // action body
    		//CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up4');
			
			if($up == 'Salvar'){
				
				$titulo = $this->getRequest()->getPost('titulo4');
				$desc4 = $this->getRequest()->getPost('desc4');
				$linkPrincipal4 = $this->getRequest()->getPost('linkPrincipal4');
				$linkExterno = $this->getRequest()->getPost('linkExterno');
				
				
				//DEFINE DESTINO
				$dir = 'upload/grupo';
				$upload->setDestination('upload/grupo');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Principal();

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
										'tituloPrincipal'	=> 	$titulo,
										'descPrincipal'		=>	$desc4,
										'linkPrincipal'		=> 	$linkPrincipal4,
										'linkExterno'		=>  $linkExterno,
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome
										);
							$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 18');		
							//$modelUpload->insert($data);
							$modelUpload->update($data, $where);
							
							$this->_redirect('/admin/grupoterceiro/index/msg/1');
								
						}else{
							$this->_redirect('/admin/grupoterceiro/index/msg/2');
						}
					}else{
						
						$data = array(
									'tituloPrincipal'	=> 	$titulo,
									'descPrincipal'		=>	$desc4,
									'linkPrincipal'		=> 	$linkPrincipal4,
									'linkExterno'		=>  $linkExterno
									);
						$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 18');
						$modelUpload->update($data, $where);
						
						$this->_redirect('/admin/grupoterceiro/index/msg/1');
					}
			
					endforeach;
					
				}else{
					$data = array(
								'tituloPrincipal'	=> 	$titulo,
								'descPrincipal'		=>	$desc4,
								'linkPrincipal'		=> 	$linkPrincipal4,
								'linkExterno'		=>  $linkExterno
								);
					$where = $modelUpload->getAdapter()->quoteInto('idPrincipal = 18');
					$modelUpload->update($data, $where);
					
					$this->_redirect('/admin/grupoterceiro/index/msg/1');
				}
				$this->_redirect('/admin/grupoterceiro/index/msg/2');
			}
		}
    }
    
    

}

