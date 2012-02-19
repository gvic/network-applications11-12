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
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL))
            throw new InvalidValueException($this->readableName, $this->value);
    }

}
