<?php

require_once 'db/fields/AbstractField.class.php';
require_once 'db/fields/validators/DoubleFieldValidator.class.php';

class DoubleField extends AbstractField {

    public function __construct() {
        parent::__construct();
    }
   
    public function getDBType() {
        return 'double';
    }

}
