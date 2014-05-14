<?php

class Plugin_Auth extends Zend_Controller_Plugin_Abstract{


	public function preDispatch(Zend_Controller_Request_Abstract $request){

		//Verifi��o

		$upload = $request->getParams();

		$module = $request->getModuleName();
		$controller = $request->getControllerName();
		$action = $request->getActionName();


		//if(($module != 'default') && ($upload != 'upload') && ($action != 'envia')){
		if($module != 'default'){

			$auth = Zend_Auth::getInstance();

			if(!$auth->hasIdentity()){

				$request->setModuleName('default');
				$request->setControllerName('login');
				$request->setActionName('index');

			}
		}


	}

}

?>