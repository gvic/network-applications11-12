<?php

require_once 'db/fields/TextField.class.php';
require_once 'db/fields/validators/EmailFieldValidator.class.php';

class EmailField extends TextField{

    function __construct() {
        parent::__construct();
        $this->validator = new EmailFieldValidator();
        $this->validator->setConstraint('max_length',255);
    }

    

}
;