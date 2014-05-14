<?php
class Admin_ImagemfinalController extends Zend_Controller_Action{
	
    
    public function init()
    {
    	/* Initialize action controller here */
    	$read = Zend_Auth::getInstance()->getStorage()->read();
    	$this->view->read = $read;
    }
    
 public function indexAction(){
    	
        
        $imgfinalModel = new Admin_Model_DbTable_Imagemfinal();
        $where = $imgfinalModel->getAdapter()->quoteInto('id = ?', 1);
        $fotos = $imgfinalModel->select()->where($where);
        
        $select =  $imgfinalModel->getAdapter()->fetchRow($fotos);
        $this->view->salvo = false;
        
        $this->view->imagemfinal = $select;
        
        
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
                	$data['nome'] = $nomeImg;
                	
                	// print_r($data); die;
                	 
                	 
                
                
                
                	$where = $imgfinalModel->getAdapter()->quoteInto('id = ?', 1);
                	 
                	$fotos = $imgfinalModel->select()->where($where);
                	$select =  $imgfinalModel->getAdapter()->fetchRow($fotos);
                	 
                	 
                	$imgfinalModel->update($data, $where);
                	 
                	move_uploaded_file($_FILES['arquivo1']['tmp_name'], (APPLICATION_PATH."/../public/upload/imagemfinal/".$nomeImg));
                	unlink((APPLICATION_PATH."/../public/upload/imagemfinal/".$select['nome']));
                	$where = $imgfinalModel->getAdapter()->quoteInto('id = ?', 1);
                	
                	$fotos = $imgfinalModel->select()->where($where);
                	$select =  $imgfinalModel->getAdapter()->fetchRow($fotos);
                	
                	$this->view->salvo = true;
                	
                	
                	$this->view->imagemfinal = $select;
            }else{
            	
                $this->view->salvo = false;
            }
        	 
        }
        
        
        
        
    }
    
    
}