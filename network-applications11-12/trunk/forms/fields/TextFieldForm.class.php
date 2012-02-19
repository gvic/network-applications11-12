<?php

require_once 'forms/fields/AbstractFieldForm.class.php';
require_once 'db/fields/validators/TextFieldValidator.class.php';


class TextFieldForm extends AbstractFieldForm {

    public function __construct() {
        parent::__construct();
    }
    
    public function setAttributes($modelField) {
        parent::setAttributes($modelField);
        $this->attrs['maxlength'] = $modelField->getAttribute('max_length');        
    }

    public function getTagType() {
        return 'input';
    }

    public function setStaticAttributes() {
        $this->attrs['type'] = 'text';
    }

}

