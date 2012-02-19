<?php
class NoEntryException extends Exception{
	function __construct($modelName){
		$message = "No entry matches the criteria for the model '$modelName' ";
		parent::__construct($message, 0);
	}
}