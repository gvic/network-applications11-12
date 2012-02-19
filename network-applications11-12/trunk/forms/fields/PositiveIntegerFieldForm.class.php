<?php

require_once 'forms/fields/IntegerFieldForm.class.php';
require_once 'db/fields/validators/PositiveIntegerFieldValidator.class.php';


class PositiveIntegerFieldForm extends IntegerFieldForm {

    public function __construct() {
        parent::__construct();
        $this->validator = new PositiveIntegerFieldValidator();
    }

}
