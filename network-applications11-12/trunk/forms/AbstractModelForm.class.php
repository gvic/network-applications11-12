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
    protected $modelInstance;

    public function __construct($postData, $modelInstance = null, $fileData = array()) {
        $this->setModelClassName();
        $this->modelInstance = $modelInstance;
        $this->setFormAttribute("name", $this->modelClassName . "_form");
        $this->setFormAttribute("id", $this->modelClassName . "_id");

        if (!empty($postData)) {
            if (!empty($fileData)) {
                $postData = array_merge($postData, $fileData);
            }
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
        $this->formFields[$key]->setValidator($attrs->getValidator());
        $this->formFields[$key]->setName($key);
    }

    protected function setFieldsAttributes() {
        parent::setFieldsAttributes();
        foreach ($this->formFields as $key => $field) {
            if (!$field->isExcluded()) {
                if (array_key_exists($key, $this->data)) {
                    $this->modelInstance->setFieldValue($key, $this->data[$key]);
                }
            }
        }
    }

    public function setFieldValue($fieldName, $val) {
        parent::setFieldValue($fieldName, $val);
        $this->modelInstance->setFieldValue($fieldName, $val);
    }

    public function save($insert = true) {
        if ($insert)
            $this->modelInstance->save();
        else {
            $this->modelInstance->update($this->data);
        }
    }

}