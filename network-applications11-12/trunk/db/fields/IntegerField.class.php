<?php

require_once 'db/fields/AbstractField.class.php';
require_once 'db/fields/validators/IntegerFieldValidator.class.php';

class IntegerField extends AbstractField {

    function __construct() {
        parent::__construct();
        $this->validator = new IntegerFieldValidator();
    }

    public function getDBType() {
        return 'int(11)';
    }

}

