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
class TextFieldValidator extends AbstractValidator {
    
    public function __construct() {
        parent::__construct();
        $this->setConstraint('max_length', 255);
    }

    protected function validateType() {
        
    }

    protected function validateValue() {
        $n = strlen($this->value);
        if($n > $this->constraints['max_length']){
            throw new InvalidValueException($this->value);
        }
    }

}

?>
