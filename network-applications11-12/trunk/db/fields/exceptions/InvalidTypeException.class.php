<?php

class InvalidTypeException extends Exception {

    public function __construct($fieldName, $value, $code = 0, Exception $previous = null) {
        $message = "The type of the value $value for the field $fieldName is wrong";
        parent::__construct($message, $code, $previous);
    }


    public function __toString() {
        return $this->message;
    }

}