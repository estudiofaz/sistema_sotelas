<?php

class Admin_ImagensController extends Zend_Controller_Action
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
        
    	$modelImagem = new Admin_Model_DbTable_Imagem();
    	$sqlImagem = $modelImagem->select()->order('idImagem DESC');
    	$imagens = $modelImagem->getAdapter()->fetchAll($sqlImagem);
    	$this->view->imagens = $imagens;

    	
		$msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Imagem adicionada com sucesso.
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
	        			Imagem removida com sucesso.
	        		</div>";
    		$this->view->alert = $alert;
    	}else{
    		$alert = null;
    	}
    	
    	
		// CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();
		
		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Enviar'){
				
				//DEFINE DESTINO
				$dir = 'upload/imagens';
				$upload->setDestination('upload/imagens');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Imagem();

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
								
						$data = array(	'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome );
										
							//$where = $modelUpload->getAdapter()->quoteInto('idLoja = 1');		
							//$modelUpload->update($data, $where);
							$modelUpload->insert($data);
							
							$this->_redirect('/admin/imagens/index/msg/1');
								
						}else{
							$this->_redirect('/admin/imagens/index/msg/3');
						}
					}
					endforeach;
				}
			}
		}
    }

    public function delAction()
    {
       // action body
       	$this->_helper->layout->setLayout('del');
       	
       	$id = $this->_getParam('id', 0);
       	
    	$modelImagem = new Admin_Model_DbTable_Imagem();
    	$sqlImagem = $modelImagem->select()->where('idImagem = ?', $id);
    	$imagem = $modelImagem->getAdapter()->fetchRow($sqlImagem);
    	$this->view->imagem = $imagem;
        
       		if($this->getRequest()->isPost()){
			$del = $this->getRequest()->getPost('up');
				if($del == 'Excluir'){
					
					//$nomeArquivo = $this->getRequest()->getPost('nomeArquivo');
					$upload = new Admin_Model_DbTable_Imagem();
						
					// EXCLUIR ARQUIVOS E A PASTA DE UPLOADS DA OBRA
					//$roodDir = 'upload/imagens';
					//$this->removeArquivo($rootDir, $nomeArquivo);
						
					// REMOVE UPLOAD DO BANCO DE DADOS
					$upload->delete('idImagem = '.(int)$id);
					
					$this->_redirect('/admin/imagens/index/msg/4');
				
				}elseif ($del == 'Cancelar'){
					
					$this->_redirect('/admin/imagens');	
				}
			
				$this->_redirect('/admin/imagens');
       		}
    	
    }


}



