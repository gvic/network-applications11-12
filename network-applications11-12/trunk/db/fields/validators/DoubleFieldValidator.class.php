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
class DoubleFieldValidator extends AbstractValidator {
    
    public function __construct() {
        parent::__construct();
    }

    protected function validateType() {
        if (!is_numeric($this->value))
            throw new InvalidTypeException($this->value);

        $this->value = (double) $this->value;
        if (!is_double($this->value))
            throw new InvalidTypeException($this->value);
    }

    protected function validateValue() {
        //TODO according Mysal specs on Double type
        return;
    }

}

?>
