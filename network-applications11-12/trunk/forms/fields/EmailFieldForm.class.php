<?php

require_once 'forms/fields/TextFieldForm.class.php';
require_once 'db/fields/validators/EmailFieldValidator.class.php';


class EmailFieldForm extends TextFieldForm {
    
    public function __construct() {
        parent::__construct();
    }

   
}

