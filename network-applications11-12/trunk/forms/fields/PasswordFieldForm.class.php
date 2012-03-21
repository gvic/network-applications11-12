<?php

require_once 'forms/fields/TextFieldForm.class.php';
require_once 'db/fields/validators/PasswordFieldValidator.class.php';

class PasswordFieldForm extends TextFieldForm {

    public function __construct() {
        parent::__construct();
    }

    public function setStaticAttributes() {
        $this->attrs['type'] = 'password';
        // reset if reloaded page
        $this->value = '';
    }
    
    public function renderField() {
        $this->value = null;
        return parent::renderField();
    }
}

