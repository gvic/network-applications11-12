<?php

require_once 'db/fields/validators/AbstractValidator.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BooleanFieldValidator
 *
 * @author victorinox
 */
class IntegerFieldValidator extends AbstractValidator {
    
    public function __construct() {
        parent::__construct();
    }

    protected function validateType() {
        if (!is_int($this->value))
            throw new InvalidTypeException($this->readableName);
    }

    protected function validateValue() {
        if(!($this->value >= -2147483648 && $this->value <= 2147483647))
            throw new InvalidValueException($this->readableName,  $this->value);
    }

}

?>
