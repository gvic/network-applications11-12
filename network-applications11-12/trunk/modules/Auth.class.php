<?php
class Auth extends AbstractModule{

	// Module deps: Messages

	public function startHook(){

		$req = $this->controller->getRequest();
		if(!array_key_exists('AUTHENTICATED', $req['SESSION'])){
			$this->controller->setSession('AUTHENTICATED',false);
		}
		$req = $this->controller->getRequest();
		$this->controller->setData('isAuth',$req['SESSION']['AUTHENTICATED']);

	}

	public function checkAccess($templateNotAuth="Index"){
		$req = $this->controller->getRequest();
		if(!$req['SESSION']['AUTHENTICATED']){
			$mess = $this->controller->getModule('Messages');
			$mess->addErrorMessage('You are not allowed to go on this page');
			return $this->controller->redirectTo($templateNotAuth,array('Messages'=>$mess->getMessages()));
		}
	}
	
	public function isAuth(){
		$req = $this->controller->getRequest();
		return $req['SESSION']['AUTHENTICATED'];
	}

	public function authenticate(array $arr){
		foreach ($arr as $key => $value) {
			$this->controller->setSession($key,$value);
		}
		$this->controller->setSession('AUTHENTICATED',true);
	}

	public function logout($message='You have been logged out'){
		$this->controller->resetGlobal('SESSION');
		session_destroy();
		session_start();
		$mess = $this->controller->getModule('Messages');
		$mess->addInfoMessage($message);
		return $mess->getMessages();
	}

	public function terminateHook(){}
}

?>