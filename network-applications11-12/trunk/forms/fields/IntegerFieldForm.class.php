<?php

require_once 'forms/fields/TextFieldForm.class.php';
require_once 'db/fields/validators/IntegerFieldValidator.class.php';


class IntegerFieldForm extends TextFieldForm {

    public function __construct() {
        parent::__construct();
    }
}

