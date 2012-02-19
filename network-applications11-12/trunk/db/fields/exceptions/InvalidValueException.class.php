<?php

class InvalidValueException extends Exception {

    public function __construct($fieldName, $value, $message = null, 
            $code = 0, Exception $previous = null) {
        // some code
        if(is_null($message))
            $message = "The value '$value' for the field '$fieldName' is not valid";
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return $this->message;
    }

}