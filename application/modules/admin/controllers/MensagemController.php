<?php

class Admin_MensagemController extends Zend_Controller_Action{
	
    
    public function init()
    {
    	/* Initialize action controller here */
    	$read = Zend_Auth::getInstance()->getStorage()->read();
    	$this->view->read = $read;
    	 
    }
    
    
    public function indexAction(){
    	
        
        $modelMensagem = new Admin_Model_DbTable_Mensagem();
        $sqlMensagem = $modelMensagem->select()->where('id = 1');
        $mensagem = $modelMensagem->getAdapter()->fetchRow($sqlMensagem);
        $this->view->mensagem = $mensagem;
        $this->view->salvar = null;
        
         
         
       
        
        //CHAMA ZEND FILE TRANSFER ADAPTER
        $upload = new Zend_File_Transfer_Adapter_Http();
        
        if($this->getRequest()->isPost()){
        		
        	$up = $this->getRequest()->getPost('up');
        
        	if($up == 'Salvar'){
        
        		$descMensagem = $this->getRequest()->getPost('dica');
        
        		//DEFINE DESTINO
        		$dir = 'upload/mensagem';
        		$upload->setDestination('upload/mensagem');
        
        		//PEGA INFO DO ARQUIVO
        		$files = $upload->getFileInfo();
        		$modelUpload = new Admin_Model_DbTable_Mensagem();
        
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
        							'dica'	          	=> 	$descMensagem,
        							'nomeArquivo'		=> 	$nomeArquivo,
        							'fotoGaleria'		=>	$nome
        					);
        					$where = $modelUpload->getAdapter()->quoteInto('id = ?',1);
        					//$modelUpload->insert($data);
        					$modelUpload->update($data, $where);
        					$this->view->salvar = 'sim';
        						
        					//$this->_redirect('/admin/empresa/index/msg/1');
        
        				}else{
        					//$this->_redirect('/admin/empresa/index/msg/2');
        				}
        			}else{
        
        				$data = array('dica'		=> 	$descMensagem );
        				$where = $modelUpload->getAdapter()->quoteInto('id = ?', 1);
        				$modelUpload->update($data, $where);
        				$this->view->salvar = 'sim';
        
        				//$this->_redirect('/admin/empresa/index/msg/1');
        			}
        				
        			endforeach;
        				
        		}else{
        			$data = array('dica'		=> 	$descMensagem );
        			$where = $modelUpload->getAdapter()->quoteInto('id = ?', 1);
        			$modelUpload->update($data, $where);
        			$this->view->salvar = 'sim';
        				
        			//$this->_redirect('/admin/empresa/index/msg/1');
        		}
        
        		//$this->_redirect('/admin/empresa/index/msg/2');
        	}
        }
         
    }
    
    
}