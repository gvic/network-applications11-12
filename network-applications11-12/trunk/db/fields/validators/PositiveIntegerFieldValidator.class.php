<?php

require_once 'db/fields/validators/IntegerFieldValidator.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BooleanFieldValidator
 *
 * @author victorinox
 */
class PositiveIntegerFieldValidator extends IntegerFieldValidator {

    public function __construct() {
        parent::__construct();
    }
    
    protected function validateValue() {
        if(!($this->value >= 0 && $this->value <= 4294967295))
            throw new InvalidValueException($this->value);
    }

}

?>
