<?php

require_once 'db/fields/AbstractField.class.php';
require_once 'db/fields/validators/TextFieldValidator.class.php';


class TextField extends AbstractField {

    function __construct() {
        parent::__construct();
        $this->validator = new TextFieldValidator();
    }
   
    public function getDBType() {
        return "varchar(255)";
    }

}

