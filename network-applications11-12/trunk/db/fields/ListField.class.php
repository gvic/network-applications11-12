<?php

require_once 'db/fields/TextField.class.php';


class ListField extends TextField {

    function __construct() {
        parent::__construct();
        $this->attributes['max_length'] = $this->validator->getConstraint('max_length');
    }
   
    public function getDBType() {
        return "varchar(255)";
    }

}