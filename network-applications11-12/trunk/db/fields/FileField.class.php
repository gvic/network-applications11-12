<?php

require_once 'db/fields/AbstractField.class.php';
require_once 'db/fields/validators/FileFieldValidator.class.php';


class FileField extends TextField{

    public function __construct() {
        parent::__construct();
        $this->validator = new FileFieldValidator();
    }


    public function setAttributes($fieldName, array $attrs) {
        parent::setAttributes($fieldName, $attrs);
        // text type can't have default value...
        $this->attributes['default_value'] = null;
    }

}