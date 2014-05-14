<?php

class Admin_FotosController extends Zend_Controller_Action
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
        $modelEventos = new Admin_Model_DbTable_Eventos();
        $sqlEventos = $modelEventos->select()
                                                ->where('perfilEventos = 0')
                                                ->order('descricao ASC');
        $eventos = $modelEventos->getAdapter()->fetchAll($sqlEventos);
        $this->view->eventos = $eventos;
    	
    }

    public function viewAction()
    {
        // action body
		$id = $this->_getParam('id', 0);
       
		$modelEventos = new Admin_Model_DbTable_Eventos();
		$sqlEventos = $modelEventos->select()
		                                        ->where('perfilEventos = 0')
		                                        ->where('id = ?', $id);
		$evento = $modelEventos->getAdapter()->fetchRow($sqlEventos);
		$this->view->eventos = $evento;

		$modelFotos = new Admin_Model_DbTable_Fotos();
		$sqlFotos = $modelFotos->select()
											->where('fotos_idEventos = ?', $id)
											->order('idFotos DESC');
		$fotos = $modelFotos->getAdapter()->fetchAll($sqlFotos);
		$this->view->fotos = $fotos;
		
		//print_r($fotos);die;
		
		$msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Foto adicionada com sucesso.
	        		</div>";
    		$this->view->alert = $alert;
    		
    	}elseif($msg == 2){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Alterações efetuadas com sucesso.
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
	        			Foto removida com sucesso.
	        		</div>";
    		$this->view->alert = $alert;
    	}else{
    		$alert = null;
    	}
    	
		
    }
    
    public function addAction()
    {
        // action body
    	
		$id = $this->_getParam('id', 0);
       
		$modelEventos = new Admin_Model_DbTable_Eventos();
		$sqlEventos = $modelEventos->select()
		                                        ->where('perfilEventos = 0')
		                                        ->where('id = ?', $id);
		$eventos = $modelEventos->getAdapter()->fetchRow($sqlEventos);
		$this->view->eventos = $eventos;
		
    	
    	
    	// CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Adicionar'){
				
				$foto_idEvento	= $this->getRequest()->getPost('fotos_idEventos');
				$tituloFoto	= $this->getRequest()->getPost('tituloFoto');
				
				/*
				$descProduto	= $this->getRequest()->getPost('descProduto');
				*/
				$descFoto    = null;
				
				//DEFINE DESTINO
				$dir = 'upload/fotos';
				$upload->setDestination('upload/fotos');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Fotos();

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
								
						$data = array(	'fotos_idEventos'	=>	$foto_idEvento,
										'tituloFoto'			=> $tituloFoto,
										
										'nomeArquivo'			=> 	$nomeArquivo,
										'nomeFoto'			=>	$nome,
						                'perfilFoto'         =>  0  );
										
							//$where = $modelUpload->getAdapter()->quoteInto('idLoja = 1');	
								
							//$modelUpload->update($data, $where);
							
						//print_r($data);die;
							$modelUpload->insert($data);
							
							$this->_redirect('/admin/fotos/view/id/'.$foto_idEvento.'/msg/1');
								
						}else{
							$this->_redirect('/admin/fotos/view/id/'.$foto_idEvento.'/msg/3');
						}
					}else{
						
						$data = array(
									'fotos_idEvento'	=>	$foto_idEvento,
									'tituloFoto'			=>  $tituloFoto,
									
						            
									);
						
						//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
						//$modelUpload->update($data, $where);
						$modelUpload->insert($data);
						
						$this->_redirect('/admin/fotos/view/id/'.$foto_idEvento.'/msg/1');
					}
			
					endforeach;
					
				}else{

					$data = array(
								'fotos_idEventos'	=>	$foto_idEvento,
								'tituloFoto'			=> $tituloFoto,
								
					            
								);
					
					//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
					//$modelUpload->update($data, $where);
					$modelUpload->insert($data);
					
					$this->_redirect('/admin/fotos/view/id/'.$foto_idEvento.'/msg/1');
				}
				
				$this->_redirect('/admin/fotos/view/id/'.$foto_idEvento.'/msg/3');
			}
		}
    	
    }

    public function delAction()
    {
        // action body
        $this->_helper->layout->setLayout('del');
		
		$id = $this->_getParam('id', 0);
		$idd = $this->_getParam('cat', 0);
       
		$modelFotos = new Admin_Model_DbTable_Fotos();
		$sqlFotos = $modelFotos->select()->where('idFotos = ?', $id);
		
		$foto = $modelFotos->getAdapter()->fetchRow($sqlFotos);
		$this->view->fotos = $foto;
		
    	
		if($this->getRequest()->isPost()){
		$del = $this->getRequest()->getPost('up');
			if($del == 'Excluir'){
				
				$modelFotos->delete('idFotos = '.(int)$id);
				
				$this->_redirect('/admin/fotos/view/id/'.$idd.'/msg/1');
			
			}elseif ($del == 'Cancelar'){
				
				$this->_redirect('/admin/fotos/view/id/'.$idd);
			}
			
			$this->_redirect('/admin/fotos/view/id/'.$idd);
			
       	}
    }

    
    public function editAction(){
    	
    	
		$cat = $this->_getParam('cat', 0);
		$id = $this->_getParam('id', 0);
       
		$modelEventos = new Admin_Model_DbTable_Eventos();
		$sqlEventos = $modelEventos->select()->where('id = ?', $cat);
		$eventos = $modelEventos->getAdapter()->fetchRow($sqlEventos);
		$this->view->eventos = $eventos;
		
		
		$modelFotos = new Admin_Model_DbTable_Fotos();
		$sqlFotos = $modelFotos->select()
											->where('idFotos = ?', $id)
											->where('foto_idEventos = ?', $cat)
											->order('idFotos DESC');
		$fotos = $modelFotos->getAdapter()->fetchRow($sqlProduto);
		$this->view->fotos = $fotos;
		
		    	
    	
        // CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Confirmar'){
								
				$idFoto		= $this->getRequest()->getPost('idFotos');
				$tituloFoto	= $this->getRequest()->getPost('tituloFoto');
				//$descProduto	= $this->getRequest()->getPost('descProduto');
				$idEvento	= $this->getRequest()->getPost('foto_idEvento');
								
				
		
				//DEFINE DESTINO
				$dir = 'upload/fotos';
				$upload->setDestination('upload/fotos');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Fotos();

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
										'tituloFoto'	=>  $tituloFoto,
										'descricaoFoto'	=>	$descFoto,
										'nomeArquivo'	=> 	$nomeArquivo,
										'nomeFoto'	=>	$nome
										);
										
							$where = $modelUpload->getAdapter()->quoteInto('idFotos = '.(int)$idFoto);		
							$modelUpload->update($data, $where);
							//$modelUpload->insert($data);
							
							$this->_redirect('/admin/fotos/view/id/'.$idEvento.'/msg/2');
								
						}else{
							$this->_redirect('/admin/fotos/view/id/'.$idEvento.'/msg/3');
						}
					}else{
						
						$data = array(
									'tituloFoto'	=> $tituloFoto,
									'descricaoFoto'	=>	$descFoto);
						
						$where = $modelUpload->getAdapter()->quoteInto('idFoto = '.(int)$idFoto);
						$modelUpload->update($data, $where);
						//$modelUpload->insert($data);
						
						$this->_redirect('/admin/fotos/view/id/'.$idEvento.'/msg/2');
					}
			
					endforeach;
					
				}else{

					$data = array(
								'tituloFoto'	=> $tituloFoto,
								'descricao'	=>	$descEvento);
					
					$where = $modelUpload->getAdapter()->quoteInto('idFotos = '.(int)$idFoto);
					$modelUpload->update($data, $where);
					//$modelUpload->insert($data);
					
					$this->_redirect('/admin/fotos/view/id/'.$idFoto
					        .'/msg/2');
				}
				
				$this->_redirect('/admin/fotos/view/id/'.$idEvento.'/msg/3');
			}
		}
    	
    	
    }
    
    



}

