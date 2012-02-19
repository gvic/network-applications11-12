<?php

require_once 'forms/AbstractModelForm.class.php';

class UserPictureForm extends AbstractModelForm {


    protected function setFieldsAttributes() {
        parent::setFieldsAttributes();
        $this->setFieldAttribute('path', 'label', 'File');
    }
    
    protected function excludeFields() {
        $this->exculdeField('user');
        $this->exculdeField('thumbnail_path');
    }

    protected function setModelClassName() {
        $this->modelClassName = "UserPicture";
    }



}