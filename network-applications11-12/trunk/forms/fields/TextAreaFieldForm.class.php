<?php

require_once 'forms/fields/AbstractFieldForm.class.php';
require_once 'db/fields/validators/TextAreaFieldValidator.class.php';


class TextAreaFieldForm extends AbstractFieldForm {
    
    public function __construct() {
        parent::__construct();
    }


    public function getTagType() {
        return 'textarea';
    }

    public function renderField() {
        $out = '<' . $this->getTagType() . ' ' . $this->renderAttributes() . '>';
        $out .= $this->value;
        $out .= '</textarea>';
        return $out;
    }

    public function setStaticAttributes() {
        return;
    }

}

