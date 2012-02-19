<?php

require_once 'utils/utils.php';

/**
 * Enter description here ...
 * @author victorinox
 *
 */
abstract class AbstractFieldForm {

    /**
     * Value attribute is stored out of the array
     * because the value of a form field can be
     * either define through an attribure or
     * between to html tag (such as textarea)
     * @var unknown
     */
    protected $value;
    protected $attrs = array();
    protected $validator;
    protected $errors = array();
    protected $render = true;

    public function __construct() {
        $this->attrs['name'] = '';
    }

    public function setLabel($v) {
        $this->attrs['label'] = $v;
        $this->validator->setFieldName($v);
        $this->validator->setReadableName($v);
        if (strlen($this->attrs['name']) == 0) {
            $this->setName(slugify($v));
        }
    }

    public function setName($n) {
        $this->attrs['name'] = $n;
        $this->attrs['id'] = $n . "_id";
    }

    public function setValue($val) {
        $this->value = $val;
        $this->validator->setValue($val);
    }

    public function getAttribute($key) {
        return $this->attrs[$key];
    }

    public function setRender($bool) {
        $this->render = $bool;
    }

    public function setValidator($v) {
        $this->validator = $v;
        if (array_key_exists('name', $this->attrs))
            $this->validator->setFieldName($this->attrs['name']);
        else {
            throw new Exception("There is no name to attach to the validator");
        }
    }

    /*
     * Allow to set the required field attribute such as type
     * for a text field.
     */

    abstract public function setStaticAttributes();

    /**
     * Setting of the remaining attributes according
     * the field type. Partly lazy call.
     * HTML5 support for required attribute
     * @param array $attrs
     */
    public function setAttributes(array $attrs) {
        if (array_key_exists('required', $attrs) && $attrs['required']) {
            $this->attrs['required'] = 'required';
        }
        if (array_key_exists('value', $attrs) && strlen($attrs['value']) > 0) {
            $this->setValue($attrs['value']);
        } else if (array_key_exists('default_value', $attrs)) {
            $this->setValue($attrs['default_value']);
        }
    }

    public function setAttribute($key, $value) {
        $this->attrs[$key] = $value;
    }

    abstract public function getTagType();

    protected function renderAttributes() {
        $out = "";
        foreach ($this->attrs as $key => $value) {
            $out .= $key . '="' . $value . '" ';
        }
        // TODO uncomment for HTML5 support
//        if($this->validator->getConstraint('required')){
//            $out .= 'required="required"';
//        }
        return $out;
    }

    public function renderField() {
        $out = '<' . $this->getTagType() . ' ' . $this->renderAttributes();
        $out .= ' value="' . $this->value . '"/>';
        return $out;
    }

    public function renderLabel() {
        $out = '<label for="' . $this->attrs['id'] . '">';
        $out .= $this->attrs['label'] . '</label>';
        return $out;
    }

    public function renderErrors() {
        $ret = "";
        if (count($this->errors) > 0) {
            $ret = "<ul>";
            foreach ($this->errors as $key => $value) {
                $ret .= "<li>$value</li>";
            }
            $ret .= "</ul>";
        }
        return $ret;
    }

    public function renderAsP() {

        $ret = "";
        if ($this->render) {
            if (array_key_exists('type', $this->attrs) &&
                    $this->attrs['type'] == 'hidden') {
                $ret = $this->renderField();
            } else {
                $ret = '<p>' . $this->renderLabel() . '<br>';
                $ret .= $this->renderErrors();
                $ret .= $this->renderField() . '</p>';
            }
        }
        return $ret;
    }

    public function isValid() {
        $this->errors = array();
        try {
            $this->validator->validate();
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return (count($this->errors) == 0);
    }

    public function getValidator() {
        return $this->validator;
    }

}