<?php

require_once 'db/fields/validators/PositiveIntegerFieldValidator.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BooleanFieldValidator
 *
 * @author victorinox
 */
class ForeignKeyFieldValidator extends PositiveIntegerFieldValidator{

    public function __construct() {
        parent::__construct();
    }
}

?>
