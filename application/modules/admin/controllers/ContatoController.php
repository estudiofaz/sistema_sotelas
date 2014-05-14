<?php

class Admin_ContatoController extends Zend_Controller_Action
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

    	$modelContato = new Admin_Model_DbTable_Contato();
    	$sqlContato = $modelContato->select()->where('idContato = 1');
    	$contato = $modelContato->getAdapter()->fetchRow($sqlContato);
    	$this->view->contato = $contato;
    	
        if($this->getRequest()->isPost()){
		$up = $this->getRequest()->getPost('up');
		
			if($up == 'Salvar'){		
				
				$id				= $this->getRequest()->getPost('idContato');
				$endereco		= $this->getRequest()->getPost('endContato');
				$cidade			= $this->getRequest()->getPost('cidadeContato');
				$telefone1		= $this->getRequest()->getPost('telefone1Contato');
				$telefone2		= $this->getRequest()->getPost('telefone2Contato');
				$telefone3		= $this->getRequest()->getPost('telefone3Contato');
				$email			= $this->getRequest()->getPost('emailContato');
				$mapa			= $this->getRequest()->getPost('mapaContato');
				
				if ($mapa != null){
					$width = 'width="600"';
					$mapa = str_replace($width, "width='100%'", $mapa);
					
					$height = 'height="450"';
					$mapa = str_replace($height, "height='250px'", $mapa);
					
					$map = explode('<br />', $mapa); 
					$mapa = $map[0]; 
				}
				
				$dados = array(
								'endContato'		=> 	$endereco,
								'cidadeContato'		=> 	$cidade,
								'telefone1Contato'	=> 	$telefone1,
								'telefone2Contato'	=> 	$telefone2,
								'telefone3Contato'	=> 	$telefone3,
								'emailContato'		=> 	$email,
								'mapaContato'		=> 	$mapa
								);
								
				//$modelContato = new Admin_Model_DbTable_Contato();
				//$modelContato->insert($dados);
				$where = $modelContato->getAdapter()->quoteInto('idContato = 1');
	        	$modelContato->update($dados, $where);
				
				$this->_redirect('/admin/contato/index/msg/1');
			}else{
				$this->_redirect('/admin/contato/index/msg/2');
			}
		}        
    	
    }


}

