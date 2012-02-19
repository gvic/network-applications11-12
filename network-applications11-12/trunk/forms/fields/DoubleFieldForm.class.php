<?php

require_once 'forms/fields/TextFieldForm.class.php';
require_once 'db/fields/validators/DoubleFieldValidator.class.php';


class DoubleFieldForm extends TextFieldForm {
    
    public function __construct() {
        parent::__construct();
        $this->validator = new DoubleFieldValidator();
    }

    
}
