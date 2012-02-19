<?php

require_once 'forms/AbstractModelForm.class.php';
require_once 'forms/fields/PasswordFieldForm.class.php';


class AccountForm extends AbstractModelForm {

    protected $formAttributes;

    function __construct($postData,$modelInstance = null) {
        $this->modelClassName = "User";
        parent::__construct($postData,$modelInstance);
    }

   
    protected function excludeFields() {
        $this->exculdeField('validated');
        $this->exculdeField('created_at');
    }
    
    protected function setFieldsAttributes() {
        parent::setFieldsAttributes();
        $this->formFields['password']->setLabeL('New Password');
    }

    protected function setFormFields() {
        parent::setFormFields();
        $field = new PasswordFieldForm();
        $field->setLabel("New password confirmation");
        $after = 'password';
        $this->addFormField($field, $after);
    }
    
    protected function validate() {
        if($this->postData['password'] != $this->postData['new_password_confirmation'])
            throw new Exception("Passwords must match !");
    }

}