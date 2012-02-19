<?php

require_once 'db/fields/AbstractField.class.php';
require_once 'db/fields/validators/BooleanFieldValidator.class.php';

class BooleanField extends AbstractField {

    public function __construct() {
        parent::__construct();
    }
    
    
    public function escape() {
        if (!is_null($this->value)) {
            if ($this->value)
                $this->value = '1';
            else {
                $this->value = '0';
            }
        }
    }

    public function getDBType() {
        return 'boolean';
    }
}
