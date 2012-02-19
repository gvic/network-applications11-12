<?php

class DuplicateEntryException extends DBException{
    
    public function __construct() {
        $this->message = "This entry already exist in the database!";
        parent::__construct();
    }	
}