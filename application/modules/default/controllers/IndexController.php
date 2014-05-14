<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        
        # SLIDERS
        $modelSlider = new Admin_Model_DbTable_Slider();
        $sqlSlider = $modelSlider->select()->order('idSlider DESC');
        $sliders = $modelSlider->getAdapter()->fetchAll($sqlSlider);
        $this->view->sliders = $sliders;
        
        # GRUPO DE IMAGENS - PRIMEIRO
        $modelPrincipal = new Admin_Model_DbTable_Principal();
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 5');
        $grupo1 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo1 = $grupo1;
        
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 6');
        $grupo2 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo2 = $grupo2;
        
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 7');
        $grupo3 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo3 = $grupo3;
        
        
        # CATEGORIAS DOS PRODUTOS
        $modelCategoria = new Admin_Model_DbTable_Categoria();
        $sqlCategoria = $modelCategoria->select()
                                                ->where('perfilCategoria = 0')
                                                ->order('descCategoria ASC');
        $categorias = $modelCategoria->getAdapter()->fetchAll($sqlCategoria);
        $this->view->categorias = $categorias;
        
        # GRUPO DE IMAGENS - SEGUNDO
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 10');
        $grupo4 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo4 = $grupo4;
        
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 11');
        $grupo5 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo5 = $grupo5;
        
        $sqlPrincipal = $modelPrincipal->select()->where('idPrincipal = 12');
        $grupo6 = $modelPrincipal->getAdapter()->fetchRow($sqlPrincipal);
        $this->view->grupo6 = $grupo6;
        
        
        # PARCEIROS
        $modelParceiro = new Admin_Model_DbTable_Parceiro();
        $sqlParceiro = $modelParceiro->select()->order('idParceiro DESC');
        $parceiros = $modelParceiro->getAdapter()->fetchAll($sqlParceiro);
        $this->view->parceiros = $parceiros;
        
        #CONTATO 
        
        
        
        
        
    }


}

