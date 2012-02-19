<?php

require_once 'db/fields/IntegerField.class.php';
require_once 'db/fields/validators/PositiveIntegerFieldValidator.class.php';


class PositiveIntegerField extends IntegerField {

    function __construct() {
        parent::__construct();
        $this->validator = new PositiveIntegerFieldValidator();
    }
}
