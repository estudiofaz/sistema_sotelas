<?php


class Admin_SlidersController extends Zend_Controller_Action
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
        $modelSlider = new Admin_Model_DbTable_Slider();
        $sqlSlider = $modelSlider->select()->order('idSlider DESC');
        $sliders = $modelSlider->getAdapter()->fetchAll($sqlSlider);
        $this->view->sliders = $sliders;
                
       	$msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Slider adicionado com sucesso.
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
	        			Slider removido com sucesso.
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

				$id				= $this->getRequest()->getPost('idSlider');
				$tituloSlider	= $this->getRequest()->getPost('tituloSlider');
				$descSlider		= $this->getRequest()->getPost('descSlider');							
		
				//DEFINE DESTINO
				$dir = 'upload/sliders';
				$upload->setDestination('upload/sliders');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Slider();

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
										'tituloSlider'	=> $tituloSlider,
										'descSlider'	=>	$descSlider,
										'nomeArquivo'	=> 	$nomeArquivo,
										'fotoGaleria'	=>	$nome
										);
							
							
							$where = $modelUpload->getAdapter()->quoteInto('idSlider = '.(int)$id);		
							$modelUpload->update($data, $where);
							/*
							$modelUpload->insert($data);
							*/
							
							$this->_redirect('/admin/sliders/index/msg/2');
								
						}else{
							$this->_redirect('/admin/sliders/index/msg/3');
						}
					}else{
						
						$data = array(
									'tituloSlider'	=> $tituloSlider,
									'descSlider'	=>	$descSlider
									);
						
						$where = $modelUpload->getAdapter()->quoteInto('idSlider = '.(int)$id);		
						$modelUpload->update($data, $where);
						/*
						$modelUpload->insert($data);
						*/
						$this->_redirect('/admin/sliders/index/msg/2');
					}
			
					endforeach;
					
				}else{

					$data = array(
								'tituloSlider'	=> $tituloSlider,
								'descSlider'	=>	$descSlider
								);
					$where = $modelUpload->getAdapter()->quoteInto('idSlider = '.(int)$id);		
					$modelUpload->update($data, $where);
					/*
					$modelUpload->insert($data);
					*/
					
					$this->_redirect('/admin/sliders/index/msg/2');
				}
				
				$this->_redirect('/admin/sliders/index/msg/3');;
			}
		}
    	
    }

    public function delAction()
    {
        // action body
       	$this->_helper->layout->setLayout('del');
       	
       	
       $id = $this->_getParam('id', 0);
       
        $modelSlider = new Admin_Model_DbTable_Slider();
        $sqlSlider = $modelSlider->select()->where('idSlider = ?', $id);
        $slider = $modelSlider->getAdapter()->fetchRow($sqlSlider);
        $this->view->slider = $slider;
        
       		if($this->getRequest()->isPost()){
			$del = $this->getRequest()->getPost('up');
				if($del == 'Excluir'){
					
					$nomeArquivo = $this->getRequest()->getPost('nomeArquivo');
	 
					$upload = new Admin_Model_DbTable_Slider();
						
					// EXCLUIR ARQUIVOS E A PASTA DE UPLOADS DA OBRA
					$roodDir = 'upload/sliders';
					$this->removeArquivo($rootDir, $nomeArquivo);
						
					// REMOVE UPLOAD DO BANCO DE DADOS
					$upload->delete('idSlider = '.(int)$id);
					
					$this->_redirect('/admin/sliders/index/msg/4');
				
				}elseif ($del == 'Cancelar'){
					
					$this->_redirect('/admin/sliders');	
				}
			
				$this->_redirect('/admin/sliders');
				
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

    public function addAction()
    {
        // action body
        // CHAMA ZEND FILE TRANSFER ADAPTER
		$upload = new Zend_File_Transfer_Adapter_Http();
		
		if($this->getRequest()->isPost()){
			
			$up = $this->getRequest()->getPost('up');
			
			if($up == 'Adicionar'){

				$tituloSlider	= $this->getRequest()->getPost('tituloSlider');
				$descSlider	= $this->getRequest()->getPost('descSlider');
				
				//DEFINE DESTINO
				$dir = 'upload/sliders';
				$upload->setDestination('upload/sliders');
				
				//PEGA INFO DO ARQUIVO
				$files = $upload->getFileInfo();
				$modelUpload = new Admin_Model_DbTable_Slider();

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
										'tituloSlider'		=>	$tituloSlider,
										'descSlider'		=>	$descSlider,
										'nomeArquivo'		=> 	$nomeArquivo,
										'fotoGaleria'		=>	$nome );
										
							//$where = $modelUpload->getAdapter()->quoteInto('idLoja = 1');		
							//$modelUpload->update($data, $where);
							$modelUpload->insert($data);
							
							$this->_redirect('/admin/sliders/index/msg/1');
								
						}else{
							$this->_redirect('/admin/sliders/index/msg/3');
						}
					}else{
						
						$data = array(	
										'tituloSlider'		=>	$tituloSlider,
										'descSlider'		=>	$descSlider);
						
						//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
						//$modelUpload->update($data, $where);
						$modelUpload->insert($data);
						
						$this->_redirect('/admin/sliders/index/msg/1');
					}
			
					endforeach;
					
				}else{

					$data = array(	
									'tituloSlider'		=>	$tituloSlider,
									'descSlider'		=>	$descSlider);
					
					//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
					//$modelUpload->update($data, $where);
					$modelUpload->insert($data);
					
					$this->_redirect('/admin/sliders/index/msg/1');
				}
				
				$this->_redirect('/admin/sliders/index/msg/3');;
			}
		}
    	
    }


}









