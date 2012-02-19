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
class DateFieldValidator extends AbstractValidator {
    
    public function __construct() {
        parent::__construct();
    }

    protected function validateType() {
        try {
            $this->value = new DateTime($this->value);
        } catch (Exception $e) {
            throw new InvalidTypeException($this->readableName);
        }
    }

    protected function validateValue() {
        return;
    }

}

?>
