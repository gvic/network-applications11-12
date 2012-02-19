<?php

require_once 'forms/fields/AbstractFieldForm.class.php';
require_once 'db/fields/validators/TextAreaFieldValidator.class.php';


class TextAreaFieldForm extends AbstractFieldForm {
    
    public function __construct() {
        parent::__construct();
        $this->validator = new TextAreaFieldValidator();
    }

    public function setAttributes(array $attrs) {
        parent::setAttributes($attrs);

        if (array_key_exists('cols', $attrs)) {
            $this->attrs['cols'] = $attrs['cols'];
        }

        if (array_key_exists('rows', $attrs)) {
            $this->attrs['rows'] = $attrs['rows'];
        }
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

