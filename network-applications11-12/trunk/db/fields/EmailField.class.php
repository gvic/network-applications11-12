<?php

require_once 'db/fields/TextField.class.php';
require_once 'db/fields/validators/EmailFieldValidator.class.php';

class EmailField extends TextField{

    function __construct() {
        parent::__construct();
    }

    

}
;