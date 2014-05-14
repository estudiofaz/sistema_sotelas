<?php

class Admin_TelefoneController extends Zend_Controller_Action
{
    
    public function init()
    {
    	/* Initialize action controller here */
    	$read = Zend_Auth::getInstance()->getStorage()->read();
    	$this->view->read = $read;
    
    }
    
    
    public function indexAction(){
    	
        
        $imgModel = new Admin_Model_DbTable_Imagem();
        $where = $imgModel->getAdapter()->quoteInto('idImagem = ?', 4);
        $fotos = $imgModel->select()->where($where);
        
        $select =  $imgModel->getAdapter()->fetchRow($fotos);
        $this->view->salvo = false;
        
        $this->view->telefone = $select;
        
        
        if($this->_request->isPost()){
        	
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
                	$data['nomeArquivo'] = $nomeImg;
                	$data['fotoGaleria'] = $img;
                	// print_r($data); die;
                	 
                	 
                
                
                
                	$where = $imgModel->getAdapter()->quoteInto('idImagem = ?', 4);
                	 
                	$fotos = $imgModel->select()->where($where);
                	$select =  $imgModel->getAdapter()->fetchRow($fotos);
                	 
                	 
                	$imgModel->update($data, $where);
                	 
                	move_uploaded_file($_FILES['arquivo1']['tmp_name'], (APPLICATION_PATH."/../public/upload/telefone/".$nomeImg));
                	unlink((APPLICATION_PATH."/../public/upload/telefone/".$select['nomeArquivo']));
                	$where = $imgModel->getAdapter()->quoteInto('idImagem = ?', 4);
                	
                	$fotos = $imgModel->select()->where($where);
                	$select =  $imgModel->getAdapter()->fetchRow($fotos);
                	
                	$this->view->salvo = true;
                	
                	
                	$this->view->telefone = $select;
            }else{
            	
                $this->view->salvo = false;
            }
        	 
        }
        
        
        
        
    }
    
    
    
    
    
    
    
    
    
}