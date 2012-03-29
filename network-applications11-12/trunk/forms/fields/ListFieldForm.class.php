<?php

require_once 'forms/fields/AbstractFieldForm.class.php';

class ListFieldForm extends AbstractFieldForm {

    protected $options = array();
    protected $optionsTexts = array();

    public function __construct() {
        parent::__construct();
    }

    public function setAttributes($fieldObj) {
        parent::setAttributes($fieldObj);
        if (!$fieldObj->getAttribute('required')) {
            $this->options[] = array(
                'index' => 0,
                'value' => null,
            );
            $this->optionsTexts[] = '------';
        }
        $list = $fieldObj->getAttribute('choices');
        foreach ($list as $key => $value) {
            $this->options[] = array('index' => $key, 'value' => $value);
            $this->optionsTexts[] = $value;
        }
    }

    protected function renderOptionsAttributes($opt) {
        $out = "";
        foreach ($this->options[$opt] as $key => $value) {
            $out .= $key . '="' . $value . '" ';
        }
        return $out;
    }

    public function renderField() {
        $out = '<' . $this->getTagType() . ' ' . $this->renderAttributes() . '>';
        foreach ($this->options as $key => $value) {
            $out .= '<option ' . $this->renderOptionsAttributes($key) . '>';
            $out .= $this->optionsTexts[$key];
            $out .= '</option>';
        }
        $out .= '</' . $this->getTagType() . '>';
        return $out;
    }

    public function getTagType() {
        return 'select';
    }

    public function setValue($val) {
        foreach ($this->optionsTexts as $index => $value){
            if($value == $val){
                $this->options[$index]['selected'] = 'selected';
            }
        }
        $this->value = $val;
        $this->validator->setValue($val);
    }

    public function setStaticAttributes() {
        return;
    }

}