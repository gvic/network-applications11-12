<?php

require_once 'db/fields/AbstractField.class.php';
require_once 'db/fields/validators/DateFieldValidator.class.php';

/**
 * Make use of DateTime feature provided since PHP 5.2.0
 */
class DateField extends AbstractField {

    public function __construct() {
        parent::__construct();
        $this->validator = new DateFieldValidator();
    }
    
    public function escape() {
        if (!is_null($this->value))
            $this->value = $this->value->format('Y-m-d');
    }

    public function getDBType() {
        return 'date';
    }

}
