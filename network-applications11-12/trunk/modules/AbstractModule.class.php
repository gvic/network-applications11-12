<?php

abstract class AbstractModule {
	
	protected $controller;
	
	function __construct(){}
	
	// Set the protected controller attribute by reference
	public function setController(&$ctrl){
		$this->controller = $ctrl;
	}
	
	// Hooks called before the action controller hook and after it.
	abstract public function startHook();
	abstract public function terminateHook();
	
}