<?php

require_once 'forms/fields/TextFieldForm.class.php';
require_once 'db/fields/validators/DateFieldValidator.class.php';


class DateFieldForm extends TextFieldForm {

    public function __construct() {
        parent::__construct();
    }

}
