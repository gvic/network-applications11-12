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
class BooleanFieldValidator extends AbstractValidator {

    public function __construct() {
        parent::__construct();
    }
        
    protected function validateType() {
        $bool = (bool) $this->value;
        if (!$bool) {
            throw new InvalidTypeException($this->readableName, $this->value);
        }
    }

    protected function validateValue() {
        return;
    }

}

?>
