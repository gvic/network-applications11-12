<?php

require_once 'forms/fields/AbstractFieldForm.class.php';
require_once 'db/fields/validators/BooleanFieldValidator.class.php';

class BooleanFieldForm extends AbstractFieldForm {

    protected static $count;

    public function __construct() {
        parent::__construct();
        BooleanFieldForm::$count = 0;
        $this->validator = new BooleanFieldValidator();
    }

    public function setAttributes(array $attrs) {
        parent::setAttributes($attrs);
        if (array_key_exists('default_value', $attrs) && $attrs['default_value']) {
            $this->attrs['checked'] = 'checked';
        }
        $this->setValue($this->getAttribute('name'));
    }
    
    public function setValue($val) {
        parent::setValue($val);
        if($this->value){
            $this->attrs['checked'] = 'checked';
        }
    }

    public function setLabel($v) {
        parent::setLabel($v);
        $this->validator->setReadableName("");
    }

    public function getTagType() {
        return 'input';
    }

    public function setStaticAttributes() {
        $this->attrs['type'] = 'checkbox';
        $this->value = "checkbox_" . BooleanFieldForm::$count;
        BooleanFieldForm::$count++;
    }

}
