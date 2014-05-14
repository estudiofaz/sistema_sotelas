<?php

class Default_EmpresaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $modelEmpresa = new Admin_Model_DbTable_Empresa();
        $sqlEmpresa = $modelEmpresa->select()->where('idEmpresa = 1');
        $empresa = $modelEmpresa->getAdapter()->fetchRow($sqlEmpresa);
        $this->view->empresa = $empresa;
    }


}

