<?php

require_once 'utils/utils.php';
require_once 'forms/AbstractForm.class.php';

/**
 * Enter description here ...
 * @author victorinox
 *
 */
abstract class AbstractModelForm extends AbstractForm {

    /**
     * Model's class$array file name
     * @var string
     */
    protected $modelClassName;
    private $modelInstance;

    public function __construct($postData, $modelInstance = null) {
        $this->setModelClassName();
        $this->modelInstance = $modelInstance;
        $this->setFormAttribute("name", $this->modelClassName . "_form");
        $this->setFormAttribute("id", $this->modelClassName . "_id");

        if (!empty($postData)) {
            parent::__construct($postData);
        } else if (!is_null($modelInstance)) {
            parent::__construct($modelInstance->getValues());
        } else {
            parent::__construct();
        }
    }

    abstract protected function setModelClassName();

    protected function setFormFields() {
        if (is_null($this->modelInstance)) {
            require_once 'models/' . $this->modelClassName . '.class.php';
            $this->modelInstance = new $this->modelClassName;
        }
        $fields = $this->modelInstance->getFields();
        $modelFieldsObjects = $this->modelInstance->getFieldsObjects();
        foreach ($fields as $key => $attrs) {
            if ($key != 'id') {
                $class = $attrs['class'];
                $modelAttrs = $modelFieldsObjects[$key];
                $this->loadFormField($key, $class, $modelAttrs);
            }
        }
    }

    private function loadFormField($key, $class, $attrs) {
        $formFieldClassFile = $class . "Form.class.php";
        require_once 'forms/fields/' . $formFieldClassFile;
        $className = $class . "Form";
        $this->formFields[$key] = new $className;
        $this->formFields[$key]->setAttributes($attrs);
        $this->formFields[$key]->setName($key);
    }

    protected function setFieldsAttributes() {
        parent::setFieldsAttributes();
        $modelFieldsObjects = $this->modelInstance->getFieldsObjects();
        foreach ($this->formFields as $key => $field) {

            if (array_key_exists($key, $modelFieldsObjects) &&
                    array_key_exists($key, $this->data))
                $modelFieldsObjects[$key]->setValue($this->data[$key]);
        }
    }

    public function save($insert=true) {
        $this->modelInstance->save($insert);
    }

}