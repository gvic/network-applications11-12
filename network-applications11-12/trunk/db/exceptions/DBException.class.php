<?php
class DBException extends Exception{
		
	public function setMessage($mess){
		$this->message = $mess;
	}
}