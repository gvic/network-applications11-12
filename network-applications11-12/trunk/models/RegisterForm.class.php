<?php

require_once 'forms/AbstractModelForm.class.php';
require_once 'forms/fields/PasswordFieldForm.class.php';
require_once 'forms/fields/BooleanFieldForm.class.php';

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
        $this->exculdeField('first_name', 'last_name', 'post_code', 'address', 'city', 'country');
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

    public function save($insert = true) {
        // Security concern: we hash and salt the password 
        // before saving it in the database
        $encryptedPass = sha1(PREFIX_SALT . $this->data['password'] . SUFFIX_SALT);
        $login = $this->data['login'];
        $dir = ROOT . MEDIA . 'static/' . $login;
        if (!is_dir($dir))
            mkdir($dir);

        $htfile = $dir . "/.htaccess";
        $this->createHtAccess($login, $this->data['password'], $htfile);
        $this->modelInstance->setFieldValue('password', $encryptedPass);
        parent::save($insert);
    }

    protected function createHtAccess($login, $password, $location) {
//        file_put_contents(HTPASSWORD_LOCATION, "\n$login:$password", FILE_APPEND);
//        $content = '
//AuthUserFile ' . HTPASSWORD_LOCATION . '
//AuthGroupFile /dev/null
//AuthName EnterPassword
//AuthType Basic
//require user ' . $login;
//        file_put_contents($content, $location);
    }

}
