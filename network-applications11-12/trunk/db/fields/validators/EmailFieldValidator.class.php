<?php

require_once 'db/fields/validators/TextFieldValidator.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BooleanFieldValidator
 *
 * @author victorinox
 */
class EmailFieldValidator extends TextFieldValidator {
    
    public function __construct() {
        parent::__construct();
    }

    protected function validateValue() {
        parent::validateValue();
        if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $this->value)){
            throw new InvalidValueException($this->readableName, $this->value);
        }
    }

}

?>
