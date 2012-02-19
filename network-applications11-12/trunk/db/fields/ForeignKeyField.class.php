<?php

require_once 'db/fields/PositiveIntegerField.class.php';
require_once 'db/fields/validators/ForeignKeyFieldValidator.class.php';

class ForeignKeyField extends PositiveIntegerField{

    public function __construct() {
        parent::__construct();
        $this->validator = new ForeignKeyFieldValidator();
    }

    public function setAttributes($fieldName, array $attrs) {
        parent::setAttributes($fieldName, $attrs);
        if ($attrs['class'] == "ForeignKeyField") {
            $this->attributes['related_model'] = $attrs['related_model'];
            require_once 'models/' . $this->attributes['related_model'] . ".class.php";
            $this->attributes['related_model_instance'] = new $this->attributes['related_model'];
            $this->attributes['foreign_key'] = true;
        }
    }

    public function getRelatedModelDBName() {
        return $this->attributes['related_model_instance']->getTableName();
    }

    public function setValue($v) {
        if ($v instanceof AbstractModel) {
            $pk = $v->getPrimaryKeyColumnName();
            $this->value = (int) $v->getValue($pk);
        } else {
            $this->value = $v;
        }
    }

    public function getName() {
        return $this->name . "_id";
    }

}
