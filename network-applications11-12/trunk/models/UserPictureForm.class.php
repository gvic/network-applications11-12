<?php

require_once 'forms/AbstractModelForm.class.php';

class UserPictureForm extends AbstractModelForm {

    protected function setFieldsAttributes() {
        parent::setFieldsAttributes();
        $this->setFieldAttribute('path', 'label', 'File');
        $this->setFieldAttribute('path', 'accept', 'image/*');
    }

    protected function excludeFields() {
        $this->exculdeField('user');
        $this->exculdeField('thumbnail_path');
    }

    protected function setModelClassName() {
        $this->modelClassName = "UserPicture";
    }

    protected function validate() {

        if ($_FILES["path"]["type"] != "image/png" && $_FILES["path"]["type"] != "image/jpeg"
                && $_FILES["path"]["type"] != "image/pjpeg")
            throw new Exception("Only png/jpeg/pjpeg are accepted format.");
        
        if($_FILES["path"]["size"] > 200)
            throw new Exception("Size file must be under 200 bytes.");
    
        if ($_FILES["path"]["error"] > 0)
            throw new Exception($_FILES["path"]["error"]);
    }

}