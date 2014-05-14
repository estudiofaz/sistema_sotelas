<?php

class Admin_DicasController extends Zend_Controller_Action
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
        $modelEmpresa = new Admin_Model_DbTable_Empresa();
        $sqlEmpresa = $modelEmpresa->select()->where('idEmpresa = 2');
        $empresa = $modelEmpresa->getAdapter()->fetchRow($sqlEmpresa);
        $this->view->empresa = $empresa;
        $this->view->salvar = null;
        
    	
        $msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
    		//$this->_redirect('/admin/dicas/index');
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
    	
    	//CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Salvar'){
								
				$descEmpresa = $this->getRequest()->getPost('descEmpresa');
		
				//DEFINE DESTINO
				$dir = 'upload/empresa';
				$upload->setDestination('upload/empresa');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Empresa();

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
										'descEmpresa'		=> 	$descEmpresa,
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome
										);
							$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = ?',2);		
							//$modelUpload->insert($data);
							$modelUpload->update($data, $where);
							$this->view->salvar = 'sim';
							
							
								
						}else{
							
						}
					}else{
						
						$data = array('descEmpresa'		=> 	$descEmpresa );
						$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = ?', 2);
						$modelUpload->update($data, $where);
						$this->view->salvar = 'sim';
						
						
						
					}
			
					endforeach;
					
				}else{
					$data = array('descEmpresa'		=> 	$descEmpresa );
					$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = ?',2);
					$modelUpload->update($data, $where);
					$this->view->salvar = 'sim';
					
					
					
					//$this->_redirect('/admin/dicas');
				}
				
				//$this->_redirect('/admin/dicas');
				
			}
		}
    	
    	
    }


}

        