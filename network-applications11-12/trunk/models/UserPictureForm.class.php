<?php

require_once 'forms/AbstractModelForm.class.php';

class UserPictureForm extends AbstractModelForm {

    protected function setFieldsAttributes() {
        parent::setFieldsAttributes();
        $this->setFieldAttribute('media_path', 'label', 'File');
        $this->setFieldAttribute('media_path', 'accept', 'image/*');
    }

    protected function excludeFields() {
        $this->exculdeField('user','thumbnail_media_path');
    }

    protected function setModelClassName() {
        $this->modelClassName = "UserPicture";
    }

    protected function validate() {

        if ($_FILES["media_path"]["type"] != "image/png" && $_FILES["media_path"]["type"] != "image/jpeg"
                && $_FILES["media_path"]["type"] != "image/pjpeg")
            throw new Exception("Only png/jpeg/pjpeg are accepted format.");
        
        $size = 50000;
        if($_FILES["media_path"]["size"] > $size)
            throw new Exception("Size file must be under $size bytes.");
    
        if ($_FILES["media_path"]["error"] > 0)
            throw new Exception($_FILES["media_path"]["error"]);
    }

}