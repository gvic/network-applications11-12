<?php

require_once 'db/fields/validators/TextFieldValidator.class.php';
require_once 'db//fields/exceptions/RequiredFieldException.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BooleanFieldValidator
 *
 * @author victorinox
 */
class FileFieldValidator extends TextFieldValidator {
    
    public function __construct() {
        parent::__construct();
    }
    
    protected function validateValue() {
        if(is_array($this->value)){
            // We check a $_FILES array entry
            if($this->constraints['required'] && $this->value['size'] == 0){
                throw new RequiredFieldException();
            }
        }
        return;
    }

}

?>
