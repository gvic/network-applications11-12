<?php

require_once 'forms/fields/AbstractFieldForm.class.php';
require_once 'db/fields/validators/TextFieldValidator.class.php';


class TextFieldForm extends AbstractFieldForm {

    public function __construct() {
        parent::__construct();
        $this->validator = new TextFieldValidator();
    }
    
    public function setAttributes(array $attrs) {
        parent::setAttributes($attrs);
        if (array_key_exists('max_length', $attrs)) {
            $this->attrs['maxlength'] = $attrs['max_length'];
        }
    }

    public function getTagType() {
        return 'input';
    }

    public function setStaticAttributes() {
        $this->attrs['type'] = 'text';
    }

}

