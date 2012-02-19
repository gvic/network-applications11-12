<?php

class InvalidTypeException extends Exception {

    public function __construct($value, $fieldName = null, $code = 0, Exception $previous = null) {
        $message = "The type of '$value' for this field is not valid.";
        if (!is_null($fieldName)) {
            $message = "The type of '$value' for the field '$fieldName' is not valid";
        }
        parent::__construct($message, $code, $previous);
    }

  
}