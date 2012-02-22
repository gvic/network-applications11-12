<?php

require_once 'utils/utils.php';
require_once 'db/fields/exceptions/InvalidValueException.class.php';
require_once 'db/fields/exceptions/RequiredFieldException.class.php';
require_once 'db/fields/exceptions/InvalidTypeException.class.php';

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
    protected $excluded = false;

    public function __construct() {
        $this->attrs['name'] = '';
        $class = substr(get_called_class(), 0, -4) . "Validator";
        require_once 'db/fields/validators/' . $class . '.class.php';
        $this->validator = new $class;
    }

    public function setExcluded($b) {
        $this->excluded = $b;
    }

    public function isExcluded() {
        return $this->excluded;
    }

    public function setLabel($v) {
        $this->attrs['label'] = $v;
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

    public function getValue() {
        return $this->value;
    }

    public function getAttribute($key) {
        return $this->attrs[$key];
    }

    public function setRender($bool) {
        $this->render = $bool;
    }

    public function setValidator($v) {
        $this->validator = $v;
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
    public function setAttributes($modelField) {

        if ($modelField->getAttribute('required'))
        //    $this->attrs['required'] = 'required';
            $this->setValue($modelField->getValue());
        $this->setLabel($modelField->getAttribute('readable_name'));
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
        if ($this->render && !$this->excluded) {
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
        if (!$this->excluded) {
            try {
                $this->validator->validate();
            } catch (Exception $e) {
                $this->errors[] = $e->getMessage();
            }
        }
        return (count($this->errors) == 0 || $this->excluded);
    }

    public function getValidator() {
        return $this->validator;
    }

}