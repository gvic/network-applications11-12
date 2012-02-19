<?php

class User extends AbstractModel{


	protected $fields =	array(
		'login'		 	=> array('class' => 'TextField','unique'=>true),
		'email'			=> array('class' => 'EmailField','unique'=>true),
		'password' 		=> array('class' => 'PasswordField',),
		'validated'		=> array('class' => 'BooleanField','default_value'=>false),
		'created_at'	=> array('class' => 'DateField',),
	);

	protected $uniqueness = array('login','email');

	public function toString(){
		return $this->getValue("login");
	}
}