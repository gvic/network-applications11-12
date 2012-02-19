<?php
require_once 'forms/fields/AbstractFieldForm.class.php';
require_once 'db/fields/validators/ForeignKeyFieldValidator.class.php';


class ForeignKeyFieldForm extends AbstractFieldForm {

    protected $options = array();
    protected $optionsTexts = array();
    
    public function __construct() {
        parent::__construct();
        $this->validator = new ForeignKeyFieldValidator();
    }
    
    public function setAttributes($fieldObj) {
        parent::setAttributes($fieldObj);
        if(!$fieldObj->getAttribute('required')) {
            $this->options[] = array(
                    'index'=>0,
                    'value'=>null,
            );
            $this->optionsTexts[] = '------';
        }
    }

    protected function renderOptionsAttributes($opt) {
        $out = "";
        foreach ($this->options[$opt] as $key => $value) {
            $out .= $key.'="'.$value.'" ';
        }
        return $out;
    }

    public function renderField() {
        $out = '<'.$this->getTagType().' '.$this->renderAttributes().'>';
        foreach ($this->options as $key => $value) {
            $out .= '<option '.$this->renderOptionsAttributes($key).'>';
            $out .= $this->optionsTexts[$key];
            $out .= '</option>';
        }
        $out .= '</'.$this->getTagType().'>';
        return $out;
    }

    public function getTagType() {
        return 'select';
    }

    public function setStaticAttributes() {
        return;
    }

}
