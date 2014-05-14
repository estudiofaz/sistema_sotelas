<?php

class Admin_ParceirosController extends Zend_Controller_Action
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
        $modelParceiro = new Admin_Model_DbTable_Parceiro();
        $sqlParceiro = $modelParceiro->select()->order('idParceiro DESC');
        $parceiros = $modelParceiro->getAdapter()->fetchAll($sqlParceiro);
        $this->view->parceiros = $parceiros;
        
        $msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Parceiro adicionado com sucesso.
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
	        			Parceiro removido com sucesso.
	        		</div>";
    		$this->view->alert = $alert;    		
    	}else{
    		$alert = null;
    	}
        
		// CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();

		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Enviar Arquivo'){

		
				//DEFINE DESTINO
				$dir = 'upload/parceiros';
				$upload->setDestination('upload/parceiros');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Parceiro();

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
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome
										);
							//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');		
							$modelUpload->insert($data);
							//$modelUpload->update($data, $where);
							
							$this->_redirect('/admin/parceiros/index/msg/1');
								
						}else{
							$this->_redirect('/admin/parceiros/index/msg/2');
						}
					}
			
					endforeach;
					
				}

				$this->_redirect('/admin/parceiros/index/msg/2');
			}
		}
    	
    	
    }

    public function delAction()
    {
        // action body
       	$this->_helper->layout->setLayout('del');
       	
       	
       $id = $this->_getParam('id', 0);
       
        $modelParceiro = new Admin_Model_DbTable_Parceiro();
        $sqlParceiro = $modelParceiro->select()->where('idParceiro = ?', $id);
        $parceiro = $modelParceiro->getAdapter()->fetchRow($sqlParceiro);
        $this->view->parceiro = $parceiro;

       		if($this->getRequest()->isPost()){
			$del = $this->getRequest()->getPost('up');
				if($del == 'Excluir'){
					
					$nomeArquivo = $this->getRequest()->getPost('nomeArquivo');
	 
					$upload = new Admin_Model_DbTable_Parceiro();
						
					// EXCLUIR ARQUIVOS E A PASTA DE UPLOADS DA OBRA
					$roodDir = 'upload/parceiros';
					$this->removeArquivo($rootDir, $nomeArquivo);
						
					// REMOVE UPLOAD DO BANCO DE DADOS
					$upload->delete('idParceiro = '.(int)$id);
					
					$this->_redirect('/admin/parceiros/index/msg/3');
				
				}elseif ($del == 'Cancelar'){
					
					$this->_redirect('/admin/parceiros');	
				}
			
				$this->_redirect('/admin/parceiros');
				
       		}
				
				

	}

	
	public function removeArquivo($rootDir, $nomeArquivo)
	{
		if (!is_dir($rootDir))
		{
			return false;
		}

		if (!preg_match("/\\/$/", $rootDir))
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