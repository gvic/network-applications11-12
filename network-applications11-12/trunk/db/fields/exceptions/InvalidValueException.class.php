<?php

class InvalidValueException extends Exception {

    public function __construct($value, $fieldName = null, $message = null, $code = 0, Exception $previous = null) {
        // some code
        if (is_null($message)) {
            if (is_null($fieldName)) {
                $message = "The value '$value' for this field is not valid.";
            } else {
                $message = "The value '$value' for the field '$fieldName' is not valid";
            }
        }
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

}