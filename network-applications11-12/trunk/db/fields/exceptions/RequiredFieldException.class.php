
<?php

class RequiredFieldException extends Exception {

    // Redefine the exception so message isn't optional
    public function __construct($fieldName, $code = 0, Exception $previous = null) {
        // some code
        $message = "The field '$fieldName' is required";
        if (is_null($fieldName) || ( is_string($fieldName) && strlen($fieldName) == 0)) {
            $message = "This field is required";
        }

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return $this->message;
    }

}

?>