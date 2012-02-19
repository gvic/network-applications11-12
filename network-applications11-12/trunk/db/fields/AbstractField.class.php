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
    }
    
    abstract public function getDBType();

    public function setAttribute($key, $value) {
        $this->attributes[$key] = $value;
    }

    public function setAttributes($fieldName, array $attrs) {
        $this->name = $fieldName;
        $this->validator->setFieldName($fieldName);

        if (array_key_exists('readable_name', $attrs) && !is_null($attrs['readable_name'])) {
            $this->attributes['readable_name'] = $attrs['readable_name'];
        } else {
            $this->attributes['readable_name'] = slug_to_readable($this->name);
        }
        $this->validator->setReadableName($this->attributes['readable_name']);

        // others params not mandatory
        if (array_key_exists('auto_increment', $attrs)) {
            $this->attributes['auto_increment'] = $attrs['auto_increment'];
        }
        if (array_key_exists('primary_key', $attrs)) {
            $this->attributes['primary_key'] = $attrs['primary_key'];
        }

        if (array_key_exists('default_value', $attrs)) {
            $this->attributes['default_value'] = $attrs['default_value'];
        }
        if (array_key_exists('required', $attrs)) {
            $this->attributes['required'] = $attrs['required'];
            $this->validator->setConstraint('required',$attrs['required']);
        }
        if (array_key_exists('unique', $attrs)) {
            $this->attributes['unique'] = $attrs['unique'];
        }
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

    public function escape() {
        if (!is_null($this->value) && !is_numeric($this->value))
            $this->value = trim(mysql_escape_string($this->value));
        if (!is_null($this->attributes['default_value']) && !is_numeric($this->attributes['default_value']))
            $this->attributes['default_value'] = mysql_escape_string($this->attributes['default_value']);
    }

    public function clean() {
        if (!$this->attributes['auto_increment']){
            $this->validator->validate();
            $this->escape();
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
    
    public function getValidator(){
        return $this->validator;
    }

}

