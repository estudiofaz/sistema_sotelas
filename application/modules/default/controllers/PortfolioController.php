<?php

class Default_PortfolioController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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
        
        # CATEGORIA
        $modelCategoria = new Admin_Model_DbTable_Categoria();
        $sqlCategoria = $modelCategoria->select()
                                                ->where('perfilCategoria = 1')
                                                ->where('idCategoria = ?', $id);
        $categoria = $modelCategoria->getAdapter()->fetchRow($sqlCategoria);
        $this->view->categoria = $categoria;
        
        # PRODUTOS
        $modelProduto = new Admin_Model_DbTable_Produto();
        $sqlProduto = $modelProduto->select()
                                            ->where('perfilProduto = 1')
                                            ->where('categoria_idCategoria = ?', $id)
                                            ->order('idProduto DESC');
        $produtos = $modelProduto->getAdapter()->fetchAll($sqlProduto);
        $this->view->produtos = $produtos;
        
        # CATEGORIAS
        $sqlCategoria = $modelCategoria->select()
                                                ->where('perfilCategoria = 1')
                                                ->order('descCategoria ASC');
        $categorias = $modelCategoria->getAdapter()->fetchAll($sqlCategoria);
        $this->view->categorias = $categorias;        
    }


}



