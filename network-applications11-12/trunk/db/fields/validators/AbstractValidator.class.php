<?php

require_once 'db/fields/exceptions/InvalidValueException.class.php';
require_once 'db/fields/exceptions/RequiredFieldException.class.php';
require_once 'db/fields/exceptions/InvalidTypeException.class.php';
require_once 'utils/utils.php';

/**
 * Description of AbstractValidator
 *
 * @author victorinox
 */
abstract class AbstractValidator {

    protected $value;
    protected $constraints;
    
    public function __construct() {
        $this->constraints = array('required'=>true);
    }

    public function setConstraint($key, $val) {
        $this->constraints[$key] = $val;
    }
    
    public function getConstraint($key){
        if(array_key_exists($key, $this->constraints)){
            return $this->constraints[$key];
        }
        else
            return null;
    }

    public function setValue($v) {
        $this->value = $v;
    }

    protected function validateRequired() {
        if (array_key_exists('required', $this->constraints) &&
                $this->constraints['required']) {
            if (is_null($this->value) || ( is_string($this->value) && strlen($this->value) == 0)) {
                throw new RequiredFieldException();
            }
        }
    }

    abstract protected function validateType();

    abstract protected function validateValue();

    public function validate() {
        $this->validateRequired();
        $this->validateType();
        $this->validateValue();
    }

}

?>
