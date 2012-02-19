<?php
class MultipleEntryException extends Exception{
	function __construct($modelName){
		$message = "Several entries match the criteria for the model '$modelName' ";
		parent::__construct($message, 0);
	}
}