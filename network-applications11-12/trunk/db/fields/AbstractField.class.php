<?php

require_once 'utils/utils.php';

/**
 *
 * No database back-end selection available yet...
 * Compatibility only with MySQL specifications
 * @author victorinox
 *
 */
abstract class AbstractField {

    protected $attributes;
    protected $name;
    protected $value;
    protected $validator;

    public function __construct() {
        $this->attributes = array(
            'primary_key' => false,
            'auto_increment' => false,
            'readable_name' => null,
            'required' => true,
            'unique' => false,
            'default_value' => null,
            'foreign_key' => false,
            'related_model' => null,
            'related_model_instance' => null,
        );
        $this->value = null;
        $class = get_called_class()."Validator";
        require_once 'db/fields/validators/'.$class.'.class.php';
        $this->validator = new $class;
    }

    abstract public function getDBType();

    public function setAttribute($key, $value) {
        $this->attributes[$key] = $value;
    }

    public function setAttributes($fieldName, array $attrs) {
        $this->name = $fieldName;

        if (array_key_exists('readable_name', $attrs) && strlen($attrs['readable_name'])>0) {
            $this->attributes['readable_name'] = $attrs['readable_name'];
            unset($attrs['readable_name']);     
        } else {
            $this->attributes['readable_name'] = slug_to_readable($this->name);
        }
        if (array_key_exists('required', $attrs)) {
            $this->attributes['required'] = $attrs['required'];
            $this->validator->setConstraint('required', $attrs['required']);
            unset($attrs['required']);
        }
        $this->attributes = array_merge($this->attributes,$attrs);
        // others params not mandatory
//        if (array_key_exists('auto_increment', $attrs)) {
//            $this->attributes['auto_increment'] = $attrs['auto_increment'];
//        }
//        if (array_key_exists('primary_key', $attrs)) {
//            $this->attributes['primary_key'] = $attrs['primary_key'];
//        }
//
//        if (array_key_exists('default_value', $attrs)) {
//            $this->attributes['default_value'] = $attrs['default_value'];
//        }
//        if (array_key_exists('unique', $attrs)) {
//            $this->attributes['unique'] = $attrs['unique'];
//        }
    }

    public function getAttribute($key) {
        return $this->attributes[$key];
    }

    public function setName($v) {
        $this->name = $v;
    }

    public function setValue($v) {
        $this->value = $v;
        $this->validator->setValue($v);
    }

    public function reset() {
        $this->setValue($this->attributes['default_value']);
    }

    public function clean() {
        if (!$this->attributes['auto_increment']) {
            $this->validator->validate();
        }
    }

    public function getValue() {
        return $this->value;
    }

    public function getName() {
        return $this->name;
    }

    public function __toString() {
        return $this->name . " ";
    }

    public function getValidator() {
        return $this->validator;
    }

}

