<?php

require_once 'db/fields/validators/TextFieldValidator.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BooleanFieldValidator
 *
 * @author victorinox
 */
class EmailFieldValidator extends TextFieldValidator {

    public function __construct() {
        parent::__construct();
    }

    protected function validateValue() {
        parent::validateValue();
        if (!$this->validEmail())
            throw new InvalidValueException($this->readableName, $this->value);
    }

    /**
     * @author Douglas Lovell on Linux Journal
      Validate an email address.
      Provide email address (raw input)
      Returns true if the email address has the email
      address format and the domain exists.
     */
    protected function validEmail() {
        $isValid = true;
        $atIndex = strrpos($this->value, "@");
        if (is_bool($atIndex) && !$atIndex) {
            $isValid = false;
        } else {
            $domain = substr($this->value, $atIndex + 1);
            $local = substr($this->value, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
                // local part length exceeded
                $isValid = false;
            } else if ($domainLen < 1 || $domainLen > 255) {
                // domain part length exceeded
                $isValid = false;
            } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
                // local part starts or ends with '.'
                $isValid = false;
            } else if (preg_match('/\\.\\./', $local)) {
                // local part has two consecutive dots
                $isValid = false;
            } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
                // character not valid in domain part
                $isValid = false;
            } else if (preg_match('/\\.\\./', $domain)) {
                // domain part has two consecutive dots
                $isValid = false;
            } else if
            (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
                // character not valid in local part unless 
                // local part is quoted
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                    $isValid = false;
                }
            }
            if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
                // domain not found in DNS
                $isValid = false;
            }
        }
        return $isValid;
    }

}

?>
