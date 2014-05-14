<?php

class Default_ContatoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $modelContato = new Admin_Model_DbTable_Contato();
        $sqlContato = $modelContato->select()->where('idContato = 1');
        $contato = $modelContato->getAdapter()->fetchRow($sqlContato);
        $this->view->contato = $contato;
    }


}

