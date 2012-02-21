<?php

require_once 'forms/AbstractModelForm.class.php';
require_once 'forms/fields/PasswordFieldForm.class.php';


class AccountForm extends AbstractModelForm {

    protected $formAttributes;

    function __construct($postData,$modelInstance = null) {
        $this->modelClassName = "User";
        parent::__construct($postData,$modelInstance);
    }

    protected function setModelClassName() {
        $this->modelClassName = "User";
    }
   
    protected function excludeFields() {
        $this->exculdeField('validated','created_at','password');
    }
    
    protected function setFieldsAttributes() {
        parent::setFieldsAttributes();
        $this->setFieldAttribute('login', 'disabled', 'disabled');
    }
    
    protected function validate() {
        return true;
    }
    
    public function save() {
        parent::save(false);
    }


}