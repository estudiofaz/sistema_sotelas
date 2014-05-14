<?php

class Admin_PortfolioController extends Zend_Controller_Action
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
                                                	->where('perfilCategoria = 1')
                                                	->order('descCategoria ASC');
        	$categorias = $modelCategoria->getAdapter()->fetchAll($sqlCategoria);
        	$this->view->categorias = $categorias;
        	 
        }
        
        public function viewAction()
        {
        	// action body
        	$id = $this->_getParam('id', 0);
        	 
        	$modelCategoria = new Admin_Model_DbTable_Categoria();
        	$sqlCategoria = $modelCategoria->select()
                                                	->where('perfilCategoria = 1')
                                                	->where('idCategoria = ?', $id);
        	$categoria = $modelCategoria->getAdapter()->fetchRow($sqlCategoria);
        	$this->view->categoria = $categoria;
        
        	$modelProduto = new Admin_Model_DbTable_Produto();
        	$sqlProduto = $modelProduto->select()
        	                                    ->where('perfilProduto = 1')
                                            	->where('categoria_idCategoria = ?', $id)
                                            	->order('idProduto DESC');
        	$produtos = $modelProduto->getAdapter()->fetchAll($sqlProduto);
        	$this->view->produtos = $produtos;
        
        	$msg = $this->_getParam('msg', 0);
        	if ($msg == 1){
        		$alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Produto adicionado com sucesso.
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
	        			Produto removida com sucesso.
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
        	 
        	$modelCategoria = new Admin_Model_DbTable_Categoria();
        	$sqlCategoria = $modelCategoria->select()
                                                	->where('perfilCategoria = 1')
                                                	->where('idCategoria = ?', $id);
        	$categoria = $modelCategoria->getAdapter()->fetchRow($sqlCategoria);
        	$this->view->categoria = $categoria;
        	 
        	 
        	// CHAMA ZEND FILE TRANSFER ADAPTER
        	$upload = new Zend_File_Transfer_Adapter_Http();
        
        	if($this->getRequest()->isPost()){
        			
        		$up = $this->getRequest()->getPost('up');
        			
        		if($up == 'Adicionar'){
        
        			$categoria_idCategoria	= $this->getRequest()->getPost('categoria_idCategoria');
        			$tituloProduto	= $this->getRequest()->getPost('tituloProduto');
        			/*
        			$descProduto	= $this->getRequest()->getPost('descProduto');
        			*/
        			//$tituloProduto  = null;
        			$descProduto    = null;
        
        			//DEFINE DESTINO
        			$dir = 'upload/produtos';
        			$upload->setDestination('upload/produtos');
        
        			//PEGA INFO DO ARQUIVO
        			$files = $upload->getFileInfo();
        			$modelUpload = new Admin_Model_DbTable_Produto();
        
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
        
        						$data = array(	'categoria_idCategoria'	=>	$categoria_idCategoria,
        								'tituloProduto'			=> $tituloProduto,
        								'descProduto'			=>	$descProduto,
        								'nomeArquivo'			=> 	$nomeArquivo,
        								'fotoGaleria'			=>	$nome,
        						        'perfilProduto'         =>  1 
        						      );
        
        						//$where = $modelUpload->getAdapter()->quoteInto('idLoja = 1');
        						//$modelUpload->update($data, $where);
        						$modelUpload->insert($data);
        							
        						$this->_redirect('/admin/portfolio/view/id/'.$categoria_idCategoria.'/msg/1');
        
        					}else{
        						$this->_redirect('/admin/portfolio/view/id/'.$categoria_idCategoria.'/msg/3');
        					}
        				}else{
        
        					$data = array(
        							'categoria_idCategoria'	=>	$categoria_idCategoria,
        							'tituloProduto'			=> $tituloProduto,
        							'descProduto'			=>	$descProduto,
        					        'perfilProduto'         =>  1
        					);
        
        					//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
        					//$modelUpload->update($data, $where);
        					$modelUpload->insert($data);
        
        					$this->_redirect('/admin/portfolio/view/id/'.$categoria_idCategoria.'/msg/1');
        				}
        					
        				endforeach;
        					
        			}else{
        
        				$data = array(
        						'categoria_idCategoria'	=>	$categoria_idCategoria,
        						'tituloProduto'			=> $tituloProduto,
        						'descProduto'			=>	$descProduto,
        				        'perfilProduto'         =>  1
        				);
        					
        				//$where = $modelUpload->getAdapter()->quoteInto('idEmpresa = 1');
        				//$modelUpload->update($data, $where);
        				$modelUpload->insert($data);
        					
        				$this->_redirect('/admin/portfolio/view/id/'.$categoria_idCategoria.'/msg/1');
        			}
        
        			$this->_redirect('/admin/portfolio/view/id/'.$categoria_idCategoria.'/msg/3');
        		}
        	}
        	 
        }
        
        public function delAction()
        {
        	// action body
        	$this->_helper->layout->setLayout('del');
        
        	$id = $this->_getParam('id', 0);
        	$idd = $this->_getParam('cat', 0);
        	 
        	$modelProduto = new Admin_Model_DbTable_Produto();
        	$sqlProduto = $modelProduto->select()
        	                                    ->where('perfilProduto = 1')
        	                                    ->where('idProduto = ?', $id);
        	$produto = $modelProduto->getAdapter()->fetchRow($sqlProduto);
        	$this->view->produto = $produto;
        	 
        	if($this->getRequest()->isPost()){
        		$del = $this->getRequest()->getPost('up');
        		if($del == 'Excluir'){
        
        			$modelProduto->delete('idProduto = '.(int)$id);
        
        			$this->_redirect('/admin/portfolio/view/id/'.$idd.'/msg/1');
        				
        		}elseif ($del == 'Cancelar'){
        
        			$this->_redirect('/admin/portfolio/view/id/'.$idd);
        		}
        			
        		$this->_redirect('/admin/portfolio/view/id/'.$idd);
        			
        	}
        }
        
        
        public function editAction(){
        	 
        	 
        	$cat = $this->_getParam('cat', 0);
        	$id = $this->_getParam('id', 0);
        	 
        	$modelCategoria = new Admin_Model_DbTable_Categoria();
        	$sqlCategoria = $modelCategoria->select()
        	                                        ->where('perfilCategoria = 1')
        	                                        ->where('idCategoria = ?', $cat);
        	$categoria = $modelCategoria->getAdapter()->fetchRow($sqlCategoria);
        	$this->view->categoria = $categoria;
        
        
        	$modelProduto = new Admin_Model_DbTable_Produto();
        	$sqlProduto = $modelProduto->select()
                                            	->where('perfilProduto = 1')
                                            	->where('idProduto = ?', $id)
                                            	->where('categoria_idCategoria = ?', $cat)
        	                                    ->order('idProduto DESC');
        	$produto = $modelProduto->getAdapter()->fetchRow($sqlProduto);
        	$this->view->produto = $produto;
        
        	 
        	 
        	// CHAMA ZEND FILE TRANSFER ADAPTER
        	$upload = new Zend_File_Transfer_Adapter_Http();
        
        	if($this->getRequest()->isPost()){
        			
        		$up = $this->getRequest()->getPost('up');
        			
        		if($up == 'Confirmar'){
        
        			$idProduto		= $this->getRequest()->getPost('idProduto');
        			$tituloProduto	= $this->getRequest()->getPost('tituloProduto');
        			$descProduto	= $this->getRequest()->getPost('descProduto');
        			$idCategoria	= $this->getRequest()->getPost('categoria_idCategoria');
        
        
        
        			//DEFINE DESTINO
        			$dir = 'upload/produtos';
        			$upload->setDestination('upload/produtos');
        
        			//PEGA INFO DO ARQUIVO
        			$files = $upload->getFileInfo();
        			$modelUpload = new Admin_Model_DbTable_Produto();
        
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
        								'tituloProduto'	=>  $tituloProduto,
        								'descProduto'	=>	$descProduto,
        								'nomeArquivo'	=> 	$nomeArquivo,
        								'fotoGaleria'	=>	$nome,
        						        'perfilProduto' =>  1
        						);
        
        						$where = $modelUpload->getAdapter()->quoteInto('idProduto = '.(int)$idProduto);
        						$modelUpload->update($data, $where);
        						//$modelUpload->insert($data);
        							
        						$this->_redirect('/admin/portfolio/view/id/'.$idCategoria.'/msg/2');
        
        					}else{
        						$this->_redirect('/admin/portfolio/view/id/'.$idCategoria.'/msg/3');
        					}
        				}else{
        
        					$data = array(
        							'tituloProduto'	=> $tituloProduto,
        							'descProduto'	=>	$descProduto,
        					        'perfilProduto' =>  1
        					);
        
        					$where = $modelUpload->getAdapter()->quoteInto('idProduto = '.(int)$idProduto);
        					$modelUpload->update($data, $where);
        					//$modelUpload->insert($data);
        
        					$this->_redirect('/admin/portfolio/view/id/'.$idCategoria.'/msg/2');
        				}
        					
        				endforeach;
        					
        			}else{
        
        				$data = array(
        						'tituloProduto'	=> $tituloProduto,
        						'descProduto'	=>	$descProduto,
        				        'perfilProduto' =>  1
        				
        				);
        					
        				$where = $modelUpload->getAdapter()->quoteInto('idProduto = '.(int)$idProduto);
        				$modelUpload->update($data, $where);
        				//$modelUpload->insert($data);
        					
        				$this->_redirect('/admin/portfolio/view/id/'.$idCategoria.'/msg/2');
        			}
        
        			$this->_redirect('/admin/portfolio/view/id/'.$idCategoria.'/msg/3');
        		}
        	}
        	 
        	 
        }
        
        
        
        
        
        }
        
        