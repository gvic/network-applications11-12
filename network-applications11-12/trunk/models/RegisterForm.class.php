<?php

require_once 'forms/AbstractModelForm.class.php';
require_once 'forms/fields/PasswordFieldForm.class.php';

class RegisterForm extends AbstractModelForm {

    protected function setModelClassName() {
        $this->modelClassName = "User";
    }

    protected function setFieldsAttributes() {
        parent::setFieldsAttributes();
        $this->setFieldAttribute('created_at', 'type', 'hidden');
        $this->setFieldValue('created_at', date('Y-m-d'));
    }

    protected function excludeFields() {
        $this->exculdeField('validated', 'first_name', 'last_name', 
                'post_code', 'address', 'city', 'country');
    }

    protected function setFormFields() {
        parent::setFormFields();
        $field = new PasswordFieldForm();
        $field->setLabel("Password confirmation");
        $after = 'password';
        $this->addFormField($field, $after);

        $fieldB = new BooleanFieldForm();
        $fieldB->setName("agreement");
        $fieldB->setLabel("I agree with the terms of service");
        $fieldB->setRender(false);
        $this->addFormField($fieldB);
    }

    protected function validate() {
        if ($this->data['password'] != $this->data['password_confirmation'])
            throw new Exception("Passwords must match !");
    }

}
