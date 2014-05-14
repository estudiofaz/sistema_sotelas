<?php

class Default_FotosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        
        # CATEGORIAS
        $modelEventos = new Admin_Model_DbTable_Eventos();
        $sqlEventos = $modelEventos->select()
                                                ->where('perfilEventos = 0')
                                                ->order('descricao ASC');
        $eventos = $modelEventos->getAdapter()->fetchAll($sqlEventos);
        $this->view->eventos = $eventos;
        
    }

    public function viewAction()
    {
        // action body
        
        $id = $this->_getParam('id', 0);
         
        # CATEGORIA
        $modelEventos = new Admin_Model_DbTable_Eventos();
        $sqlEventos = $modelEventos->select()
                                                ->where('perfilEventos = 0')
                                                ->where('id = ?', $id);
        $eventos = $modelEventos->getAdapter()->fetchRow($sqlEventos);
        $this->view->evento = $eventos;
        
        # PRODUTOS
        $modelFotos = new Admin_Model_DbTable_Fotos();
        $sqlFotos = $modelFotos->select()
                                            ->where('fotos_idEventos = ?', $id)
                                            ->order('idFotos DESC');
        $fotos = $modelFotos->getAdapter()->fetchAll($sqlFotos);
        $this->view->fotos = $fotos;
        
        
        # CATEGORIAS
        $sqlEventos = $modelEventos->select()
                                                ->where('perfilEventos = 0')
                                                ->order('descricao ASC');
        $eventos = $modelEventos->getAdapter()->fetchAll($sqlEventos);
        $this->view->eventos = $eventos;
        
    }


}



