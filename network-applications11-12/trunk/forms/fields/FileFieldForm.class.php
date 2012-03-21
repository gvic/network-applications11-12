<?php

require_once 'forms/fields/AbstractFieldForm.class.php';
require_once 'db/fields/validators/FileFieldValidator.class.php';


class FileFieldForm extends AbstractFieldForm {
    
    public function __construct() {
        parent::__construct();
    }

    public function getTagType() {
        return 'input';
    }

    public function setStaticAttributes() {
        $this->attrs['type'] = 'file';
    }

}
