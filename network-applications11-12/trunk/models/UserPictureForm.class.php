<?php
class UserPictureForm extends AbstractModelForm {

    function __construct($postData) {
        $this->modelClassName = "UserPicture";
        parent::__construct($postData);
    }

    protected function excludeFields() {
        $this->exculdeField('user');
    }

    protected function hookSetFieldsAttributes(){
        $this->formFields['image_name']->setValue('hello');
    }



}