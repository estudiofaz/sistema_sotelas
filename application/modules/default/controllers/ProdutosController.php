<?php

class Default_ProdutosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        
        # CATEGORIAS
        $modelCategoria = new Admin_Model_DbTable_Categoria();
        $sqlCategoria = $modelCategoria->select()
                                                ->where('perfilCategoria = 0')
                                                ->order('descCategoria ASC');
        $categorias = $modelCategoria->getAdapter()->fetchAll($sqlCategoria);
        $this->view->categorias = $categorias;
        
    }

    public function viewAction()
    {
        // action body
        
        $id = $this->_getParam('id', 0);
         
        # CATEGORIA
        $modelCategoria = new Admin_Model_DbTable_Categoria();
        $sqlCategoria = $modelCategoria->select()
                                                ->where('perfilCategoria = 0')
                                                ->where('idCategoria = ?', $id);
        $categoria = $modelCategoria->getAdapter()->fetchRow($sqlCategoria);
        $this->view->categoria = $categoria;
        
        # PRODUTOS
        $modelProduto = new Admin_Model_DbTable_Produto();
        $sqlProduto = $modelProduto->select()
                                            ->where('categoria_idCategoria = ?', $id)
                                            ->order('idProduto DESC');
        $produtos = $modelProduto->getAdapter()->fetchAll($sqlProduto);
        $this->view->produtos = $produtos;
        
        
        # CATEGORIAS
        $sqlCategoria = $modelCategoria->select()
                                                ->where('perfilCategoria = 0')
                                                ->order('descCategoria ASC');
        $categorias = $modelCategoria->getAdapter()->fetchAll($sqlCategoria);
        $this->view->categorias = $categorias;
        
    }


}



