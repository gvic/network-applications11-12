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
class PasswordFieldValidator extends TextFieldValidator {
    
    public function __construct() {
        parent::__construct();
    }

    protected function validateValue() {
        parent::validateValue();
        $n = strlen($this->value);

        if ($n < 6) {
            $message = "Your password should be composed with more than 5 characters";
            throw new InvalidValueException($this->readableName, $this->value, $message);
        }
    }

}

?>
