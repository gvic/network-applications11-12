<?php

require_once 'forms/AbstractForm.class.php';
require_once 'forms/fields/PasswordFieldForm.class.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChangePasswordForm
 *
 * @author victorinox
 */
class ChangePasswordForm extends AbstractForm{
    //put your code here
    protected function setFormFields() {
        $npwd = new PasswordFieldForm();
        $npwd->setLabel('New password');
        $this->addFormField($npwd);
        
        $npwdc = new PasswordFieldForm();
        $npwdc->setLabel('Password confirmation');
        $this->addFormField($npwdc);
    }
    protected function validate() {
        if($this->data['new_password'] != $this->data['password_confirmation'])
            throw new Exception("Passwords must match !");
    }
}

?>
