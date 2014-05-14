<?php

class Admin_EventosController extends Zend_Controller_Action
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
        $Eventos = $modelEventos->getAdapter()->fetchAll($sqlEventos);
        $this->view->eventos = $Eventos;
        
        
    	$msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Evento adicionado com sucesso.
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
	        			Evento removido com sucesso.
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
								
				$id				= $this->getRequest()->getPost('id');
				$descEventos	= $this->getRequest()->getPost('descricao');							
		
				//DEFINE DESTINO
				$dir = 'upload\eventos';
				$upload->setDestination('upload\eventos');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Eventos();

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
										'descricao'	=>	$descEventos,
										'nome'	=> 	$nomeArquivo,
										
						                 
										);
										
							$where = $modelUpload->getAdapter()->quoteInto('id = '.(int)$id);		
							$modelUpload->update($data, $where);
							//$modelUpload->insert($data);
							
							$this->_redirect('/admin/eventos/index/msg/2');
							
								
						}else{
							$this->_redirect('/admin/eventos/index/msg/3');
							
						}
					}else{
						
						$data = array('descricao'	=>	$descEventos);
						
						$where = $modelUpload->getAdapter()->quoteInto('id = '.(int)$id);
						$modelUpload->update($data, $where);
						//$modelUpload->insert($data);
						
						$this->_redirect('/admin/eventos/index/msg/2');
					}
			
					endforeach;
					
				}else{

					$data = array('descricao'	=>	$descEventos);
					
					$where = $modelUpload->getAdapter()->quoteInto('id = '.(int)$id);
					$modelUpload->update($data, $where);
					//$modelUpload->insert($data);
					
					$this->_redirect('/admin/eventos/index/msg/2');
				}
				
				$this->_redirect('/admin/eventos/index/msg/3');;
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
								
				$descEventos	= $this->getRequest()->getPost('descricao');
							
		
				//DEFINE DESTINO
				$dir = 'upload/eventos';
				$upload->setDestination('upload/eventos');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Eventos();

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
								
						$data = array(	'descricao'		=>	$descEventos,
										'nome'		=> 	$nomeArquivo,
										
						                'perfilEventos'   =>  0);
										
							//$where = $modelUpload->getAdapter()->quoteInto('idLoja = 1');		
							//$modelUpload->update($data, $where);
							
						//print_r($data); die;
							$modelUpload->insert($data);
							
							$this->_redirect('/admin/eventos/index/msg/1');
								
						}else{
							$this->_redirect('/admin/eventos/index/msg/3');
						}
					}else{
						
						$data = array('descricao'		=>	$descEventos);
						
						//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
						//$modelUpload->update($data, $where);
						$modelUpload->insert($data);
						
						$this->_redirect('/admin/categorias/index/msg/1');
					}
			
					endforeach;
					
				}else{

					$data = array('descCategoria'		=>	$descEventos);
					
					//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
					//$modelUpload->update($data, $where);
					$modelUpload->insert($data);
					
					$this->_redirect('/admin/eventos/index/msg/1');
				}
				
				$this->_redirect('/admin/eventos/index/msg/3');;
			}
		}
    	
    }

    public function delAction()
    {
        // action body
    	$this->_helper->layout->setLayout('del');
		
		$id = $this->_getParam('id', 0);
       
		$modelEventos = new Admin_Model_DbTable_Eventos();
		$sqlEventos = $modelEventos->select()->where('id = ?', $id);
		$eventos = $modelEventos->getAdapter()->fetchRow($sqlEventos);
		$this->view->eventos = $eventos;

    	
		if($this->getRequest()->isPost()){
		$del = $this->getRequest()->getPost('up');
			if($del == 'Excluir'){
				
				$modelEventos->delete('id = '.(int)$id);
				
				$this->_redirect('/admin/eventos/index/msg/4');
			
			}elseif ($del == 'Cancelar'){
				
				$this->_redirect('/admin/eventos/index');
			}
			
			$this->_redirect('/admin/eventos/index');
			
       	}
    }


}





