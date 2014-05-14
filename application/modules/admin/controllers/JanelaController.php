<?php

class Admin_JanelaController extends Zend_Controller_Action
{
    
    public function init()
    {
    	/* Initialize action controller here */
    	$read = Zend_Auth::getInstance()->getStorage()->read();
    	$this->view->read = $read;
    
    }
    
    
    public function indexAction(){
    	
        
        $janelaModel = new Admin_Model_DbTable_Janela();
        $where = $janelaModel->getAdapter()->quoteInto('idJanela = ?', 1);
        $fotos = $janelaModel->select()->where($where);
        
        $select =  $janelaModel->getAdapter()->fetchRow($fotos);
        $this->view->salvo = false;
        
        $this->view->janela = $select;
        
        
        if($this->_request->isPost()){
         
            $titulo=  $this->getRequest()->getPost('titulo');
            $mensagem=  $this->getRequest()->getPost('mensagem');
            
            if($_FILES["arquivo1"]['name']){
                    
                
                
                    
                    $img = $_FILES["arquivo1"]['name'];
                	$array = explode('.', $img);
                	$extencao = end($array);
                
                	$string = "abcdefghijklmnopqrstuvxzABCDEFGHIJKLMNOPQRSZFGDHJHJGJGHJ";
                	$nome = "";
                	for($i=0;$i<20;$i++){
                
                		$a = $string{rand(0,50)};
                		$nome =$nome.$a;
                	}
                	
                	$data = array();
                	$img = "/".$img;
                	$nomeImg = $nome.".".$extencao;
                	$data['nome'] = $nomeImg;
                	$data['titulo'] = $titulo;
                	$data['mensagem'] = $mensagem;
                 	// print_r($data); die;
                	 
                	 
                
                
                
                	$where = $janelaModel->getAdapter()->quoteInto('idJanela = ?', 1);
                	 
                	$fotos = $janelaModel->select()->where($where);
                	$select =  $janelaModel->getAdapter()->fetchRow($fotos);
                	 
                	 
                	$janelaModel->update($data, $where);
                	 
                	move_uploaded_file($_FILES['arquivo1']['tmp_name'], (APPLICATION_PATH."/../public/upload/janela/".$nomeImg));
                	unlink((APPLICATION_PATH."/../public/upload/janela/".$select['nome']));
                	$where = $janelaModel->getAdapter()->quoteInto('idJanela = ?', 1);
                	
                	$fotos = $janelaModel->select()->where($where);
                	$select =  $janelaModel->getAdapter()->fetchRow($fotos);
                	
                	$this->view->salvo = true;
                	
                	
                	$this->view->janela = $select;
            }else{
                $data['titulo'] = $titulo;
                $data['mensagem'] = $mensagem;
                $where = $janelaModel->getAdapter()->quoteInto('idJanela = ?', 1);
                
                $fotos = $janelaModel->select()->where($where);
                $select =  $janelaModel->getAdapter()->fetchRow($fotos);
                $janelaModel->update($data, $where);
                
                $this->view->janela = $select;
                $this->view->salvo = true;
            }
        	 
        }
        
        
        
        
    }
    
    
    
    
    
    
    
    
    
}