<?php
require_once 'db/exceptions/DBException.class.php';
require_once 'db/exceptions/DuplicateEntryException.class.php';

class DBExceptionManager{
	
	
	// Should contain only the error relevant for the user of the framework
	// and not for the framework developper
	private $errorMapping = array(
		1062 => 'DuplicateEntryException',
	);
	
	public function throwException($errno,$err){
		if(array_key_exists($errno,$this->errorMapping)){
			$ex = new $this->errorMapping[$errno];
			throw $ex;
		}
		echo "Mapping failed during exception managment. Original mysql error: ";
		die(mysql_error().". ERROR CODE: ".mysql_errno());
	}
}
