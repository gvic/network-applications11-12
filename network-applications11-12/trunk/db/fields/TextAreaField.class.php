<?php

require_once 'db/fields/AbstractField.class.php';
require_once 'db/fields/validators/TextAreaFieldValidator.class.php';


class TextAreaField extends AbstractField {

    function __construct() {
        parent::__construct();
    }

    public function getDBType() {
        return 'text';
    }

}

