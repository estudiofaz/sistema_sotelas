<?php

class Admin_PerfilController extends Zend_Controller_Action
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
		$msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-success'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Dados alterados com sucesso.
	        		</div>";
	      
    	}elseif ($msg == 2){
	        $alert = "<div class='alert alert-error'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Houve um erro ao alterar os dados de acesso. Tente novamente.
	        		</div>";

    	}else{
    		$alert = null;
    	}
    	$this->view->alert = $alert; 
    	
    	$read = Zend_Auth::getInstance()->getStorage()->read();
    	$id = $read->idLogin;
        //$id = $this->_getParam('id', 0);
        
    	$modelCliente = new Default_Model_DbTable_Login();
    	$sqlCliente = $modelCliente->select()
    								->where('idLogin = ?', $id)
    								->where('perfilLogin = 0');
    	$cliente = $modelCliente->getAdapter()->fetchRow($sqlCliente);
    	$this->view->cliente = $cliente;
    	
    	
        	if($this->getRequest()->isPost()){
		
		$up = $this->getRequest()->getPost('up');
		
			if($up == 'Confirmar'){
								
				$nomeLogin			= $this->getRequest()->getPost('nomeLogin');
				$responsavelLogin	= $this->getRequest()->getPost('responsavelLogin');
				$telefoneLogin		= $this->getRequest()->getPost('telefoneLogin');
					
					$data = array(
								'nomeLogin'			=> 	$nomeLogin,
								'responsavelLogin'	=> 	$responsavelLogin,
								'telefoneLogin'		=> 	$telefoneLogin
								);
					
					$where = $modelCliente->getAdapter()->quoteInto('idLogin = '.(int)$id);		
					$modelCliente->update($data, $where);
					
					$this->_redirect('/admin/perfil/index/msg/1');
			}else{
		
				$this->_redirect('/admin/perfil/index/msg/2');
			}
		
		}
    }
    
    
    public function accessAction()
    {
        // action body
    	$msg = $this->_getParam('msg', 0);
    	if ($msg == 1){
	        $alert = "<div class='alert alert-error'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Nome de usuário já cadastrado. Escolha outro nome de usuário.
	        		</div>";
	      
    	}elseif ($msg == 2){
	        $alert = "<div class='alert alert-error'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Campos obrigatórios em branco.
	        		</div>";
	        
		}elseif ($msg == 3){
	        $alert = "<div class='alert alert-error'>
	        			<button data-dismiss='alert' class='close' type='button'>&times;</button>
	        			Nova senha não confere. Digite a nova senha duas vezes iguais.
	        		</div>";
    	}else{
    		$alert = null;
    	}
    	$this->view->alert = $alert; 
    	
    	
    	$read = Zend_Auth::getInstance()->getStorage()->read();
    	$id = $read->idLogin;
        
    	$modelCliente = new Default_Model_DbTable_Login();
    	$sqlCliente = $modelCliente->select()
    								->where('idLogin = ?', $id)
    								->where('perfilLogin = 0');
    	$cliente = $modelCliente->getAdapter()->fetchRow($sqlCliente);
    	$this->view->cliente = $cliente;
    	

		if($this->getRequest()->isPost()){
		
		$up = $this->getRequest()->getPost('up');
		
			if($up == 'Confirmar'){
								
				$usuarioLogin	= $this->getRequest()->getPost('usuarioLogin');
				$novaSenha1		= $this->getRequest()->getPost('novaSenha1');
				$novaSenha2		= $this->getRequest()->getPost('novaSenha2');
				
				
				
				// NOME DE USUÁRIO EM BRANCO
				if ($usuarioLogin == null){
					
					$this->_redirect('/admin/perfil/access/msg/2');
				}else{
					
					
					if (($novaSenha1 != null) || ($novaSenha2 != null)){
						
						if ($novaSenha1 == $novaSenha2){
							
							$novaSenha = sha1($novaSenha1);	
						}else{
							
							// NOVA SENHA NÃO CONFERE
							$this->_redirect('/admin/perfil/access/msg/3');
						}
					}else {
						$novaSenha = $cliente['senhaLogin']; 	
					}
					
					
					$sqlCliente = $modelCliente->select();
					$clientes = $modelCliente->getAdapter()->fetchAll($sqlCliente);
				
				// NOME DE USUÁRIO JÁ CADASTRADO
				foreach ($clientes as $cli):
					
					if (($cli['usuarioLogin'] == $usuarioLogin) && ($cli['usuarioLogin'] != $cliente['usuarioLogin'])){
						
						$this->_redirect('/admin/perfil/access/index/msg/1');
					}
					
				endforeach;
				
					
					$data = array(
								'usuarioLogin'	=> 	$usuarioLogin,
								'senhaLogin'	=> 	$novaSenha
								);
					
					$where = $modelCliente->getAdapter()->quoteInto('idLogin = '.(int)$id);		
					$modelCliente->update($data, $where);
					
					$this->_redirect('/admin/perfil/index/msg/1');
				}
			}else{
		
				$this->_redirect('/admin/perfil/access/index/msg/2');
			}
		
		}
    }


}



