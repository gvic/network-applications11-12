<?php

require_once 'forms/AbstractModelForm.class.php';

class CheckOutForm extends AbstractModelForm {

    protected $formAttributes;

    function __construct($postData, $modelInstance = null) {
        $this->modelClassName = "User";
        parent::__construct($postData, $modelInstance);
    }

    protected function setModelClassName() {
        $this->modelClassName = "User";
    }

    protected function excludeFields() {
        $this->exculdeField('created_at', 'password', 'login','email');
    }

    protected function validate() {
        return true;
    }

    public function save() {
        parent::save(false);
    }

}