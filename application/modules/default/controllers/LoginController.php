<?php

class Default_LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('login');
    }

    public function indexAction()
    {
		//$form = new Default_Form_Login();
		
		
		$usuarioLogin = $this->getRequest()->getPost('usuarioLogin');
		$senhaLogin = $this->getRequest()->getPost('senhaLogin');
		
		
			
		//Verifica se o formulário foi postado
		if($this->getRequest()->isPost()){

			//Verifica se os dados são válidos
			if($this->getRequest()->getParams()){
					
				//Retorna a conexão
				$db = Zend_Db_Table::getDefaultAdapter();

				$adapter = new Zend_Auth_Adapter_DbTable();
				$autenticacao = $adapter->setTableName('login')					//qual tabela
										->setIdentityColumn('usuarioLogin')		//tx_usuario
										->setCredentialColumn('senhaLogin')		//tx_senha
										->setCredentialTreatment('sha1(?)')		//método de criptografia: md5 (32 caracteres), sha1(40 caracteres
										->setIdentity($usuarioLogin)			//Qual usuario
										->setCredential($senhaLogin)			//Qual senha
										->authenticate();
                
				if($autenticacao->isValid()){

					// Instanciando auth atual
					//Singleton - sempre chamar por getInstance
					$auth = Zend_Auth::getInstance();

					/* OUTRA FORMA DE GERAR SESSÃO*/
					$data = $adapter->getResultRowObject(null, 'senhaLogin'); // exclui senha da sessão
					$auth->getStorage()->write($data);


					// Definindo Perfil de acesso aos módulos
					$read = Zend_Auth::getInstance()->getStorage()->read();
					//$perfil = $read->perfil;

					//if ($perfil === 'admin'){
                    
					if($read){
						      
					    $loginModel = new Default_Model_DbTable_Login();
					    $where = $loginModel->getAdapter()->quoteInto('usuarioLogin = ?', $usuarioLogin);
					    
					    $dados = $loginModel->select()->where($where);
					    $select =  $loginModel->getAdapter()->fetchRow($dados);
					    
					    if($select['idLogin']==1){
					    
					       $this->_redirect("/admin/index/");
					    
					    }elseif($select['idLogin'] == 2){
					    	
					        $this->_redirect("/sistema/index/");
					    }
						
					
					}else{
						$this->_redirect("/default/login");
					}

				}else{
					$alert = "<div class='alert alert-error'>Houve um erro. Tente novamente.</div>";
					$this->view->alert; 
				}
			}
		}
		//$this->view->form = $form;
	}
	
	
	// LOGOUT
	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
			
		$this->_redirect('default/login/index');
	}


}

