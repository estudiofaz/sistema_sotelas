<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	public function _initAutoLoader(){
		$loader = Zend_Loader_Autoloader::getInstance();
		$loader->setFallbackAutoloader(true);
	}



	protected function _initTranslate(){

		try {
			$translate = new Zend_Translate('Array', APPLICATION_PATH . '/languages/pt_BR/Zend_Validate.php', 'pt_BR');
			Zend_Validate_Abstract::setDefaultTranslator($translate);
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}

	protected function _initLocale(){
			
		$ptBR = new Zend_Locale('pt_BR');
		$ptBR->setDefault('pt_BR');

		$data = new Zend_Date();
		$data->setLocale('pt_BR');

	}



}

