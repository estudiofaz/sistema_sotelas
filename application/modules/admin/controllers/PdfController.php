<?php

class Admin_PdfController extends Zend_Controller_Action
{
    
    public function init()
    {
    	/* Initialize action controller here */
    	$read = Zend_Auth::getInstance()->getStorage()->read();
    	$this->view->read = $read;
    
    }
    
    
    public function indexAction(){
    	
        $this->view->salvo = false;
           if($this->_request->isPost()){    	
                if($_FILES["arquivo1"]['name']){
                
                        $img = $_FILES["arquivo1"]['name'];
                    	                	 
                    	move_uploaded_file($_FILES['arquivo1']['tmp_name'], (APPLICATION_PATH."/../public/upload/pdf/arquivojanela.pdf"));
                    	               	
                    	$this->view->salvo = true;
                    	              	
                    	
                }else{
                	
                    $this->view->salvo = false;
                }
           }
        	 
        }
        
        
        
        
    
    
    
    
    
    
    
    
    
    
}