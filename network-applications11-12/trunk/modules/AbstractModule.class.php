<?php

abstract class AbstractModule {
	
	protected $controller;
	
	function __construct(){}
	
	// Set the protected controller attribute by reference
	public function setController(&$ctrl){
		$this->controller = $ctrl;
	}
	
	// Hooks called before the action controller hook and after it.
	public abstract function startHook();
	public abstract function terminateHook();
	
}