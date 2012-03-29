<?php

require_once 'forms/AbstractModelForm.class.php';

class UserPictureForm extends AbstractModelForm {

    public function __construct($postData = array(), $modelInstance = null, $fileData = array()) {
        parent::__construct($postData, $modelInstance, $fileData);
    }

    protected function setFormAttributes() {
        parent::setFormAttributes();
        $this->setFormAttribute('id', 'photoform');
    }

    protected function setFieldsAttributes() {
        parent::setFieldsAttributes();
        $this->setFieldAttribute('media_path', 'label', 'File');
        $this->setFieldAttribute('media_path', 'accept', 'image/*');
        $this->setFieldAttribute('media_path', 'id', 'photofile');
    }

    protected function setFormFields() {
        parent::setFormFields();
    }

    protected function excludeFields() {
        $this->exculdeField('user', 'thumbnail_media_path');
    }

    protected function setModelClassName() {
        $this->modelClassName = "UserPicture";
    }

    protected function validate() {
        if ($_FILES["media_path"]["type"] != "image/png" &&
                $_FILES["media_path"]["type"] != "image/jpeg" &&
                $_FILES["media_path"]["type"] != "image/pjpeg" &&
                $_FILES["media_path"]["type"] != "image/jpg")
            throw new Exception("Only png/jpeg/pjpeg/jpg are accepted format.");

        $size = 8000000; //Bytes
        if ($_FILES["media_path"]["size"] > $size)
            throw new Exception("Size file must be under $size bytes.");

        if ($_FILES["media_path"]["error"] > 0)
            throw new Exception($_FILES["media_path"]["error"]);
    }

}