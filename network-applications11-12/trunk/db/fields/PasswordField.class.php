<?php
require_once 'db/fields/TextField.class.php';
require_once 'db/fields/validators/PasswordFieldValidator.class.php';

/**
 * Description of PasswordField
 *
 * @author victorinox
 */
class PasswordField extends TextField {

    function __construct() {
        parent::__construct();
        $this->validator = new PasswordFieldValidator();
        $this->validator->setConstraint('max_length', 255);
    }


}

?>
