<?php

require_once 'forms/fields/AbstractFieldForm.class.php';
require_once 'db/fields/validators/FileFieldValidator.class.php';


class FileFieldForm extends AbstractFieldForm {
    
    public function __construct() {
        parent::__construct();
        $this->validator = new FileFieldValidator();
    }

    public function getTagType() {
        return 'input';
    }

    public function setStaticAttributes() {
        $this->attrs['type'] = 'file';
    }
    
    public function setAttributes($fieldObj) {
        parent::setAttributes($fieldObj);
        $this->setValue(null);
    }

}
