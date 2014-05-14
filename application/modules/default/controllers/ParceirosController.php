<?php

class Default_ParceirosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $modelParceiro = new Admin_Model_DbTable_Parceiro();
        $sqlParceiro = $modelParceiro->select()->order('idParceiro DESC');
        $parceiros = $modelParceiro->getAdapter()->fetchAll($sqlParceiro);
        $this->view->parceiros = $parceiros;
        
    }


}

