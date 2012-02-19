<?php

require_once 'forms/AbstractForm.class.php';
require_once 'forms/fields/TextFieldForm.class.php';
require_once 'forms/fields/PasswordFieldForm.class.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginForm
 *
 * @author victorinox
 */
class LoginForm extends AbstractForm {

    protected function setFormAttributes() {
        parent::setFormAttributes();
        $this->setFormAttribute('name', 'loginForm');
        $this->setFormAttribute('id', 'loginForm_id');
    }
    
    protected function setFormFields() {
        $uname = new TextFieldForm();
        $uname->setLabel('Login');
        $this->addFormField($uname);
        
        $pwd = new PasswordFieldForm();
        $pwd->setLabel('Password');
        $this->addFormField($pwd);
    }
    
    

}

?>
