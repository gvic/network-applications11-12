<?php

require_once 'utils/utils.php';
require_once 'forms/AbstractForm.class.php';

/**
 * Enter description here ...
 * @author victorinox
 *
 */
class AbstractModelForm extends AbstractForm {

    /**
     * Model's class$array file name
     * @var string
     */
    protected $modelClassName;
    private $modelInstance;

    public function __construct($postData, $modelInstance = null) {
        if (is_null($modelInstance)) {
            require_once 'models/' . $this->modelClassName . '.class.php';
            $this->modelInstance = new $this->modelClassName;
        } else {
            $this->modelInstance = $modelInstance;
        }
        $this->setFormAttribute("name", $this->modelClassName . "_form");
        $this->setFormAttribute("id", $this->modelClassName . "_id");

        if (!is_null($modelInstance)) {
            parent::__construct($modelInstance);
        } else {
            parent::__construct($postData);
        }
    }

    protected function mapData($data) {
        if ($data instanceof AbstractModel) {
            $modelFields = $this->modelInstance->getFieldsObjects();
            foreach ($modelFields as $key => $fieldObj) {
                if (array_key_exists($key, $this->formFields)) {
                    $val = $this->modelInstance->getValue($key);
                    $this->formFields[$key]->setValue($val);
                    $this->arrayData[$key] = $val;
                }
            }
        } else {
            $modelFieldsObjects = $this->modelInstance->getFieldsObjects();
            foreach ($data as $key => $value) {
                if (array_key_exists($key, $this->formFields)) {
                    $this->formFields[$key]->setValue($value);
                }
                if (array_key_exists($key, $modelFieldsObjects)) {
                    $modelFieldsObjects[$key]->setValue($value);
                }
            }
        }
    }

    protected function setFormFields() {
        $fields = $this->modelInstance->getFields();
        foreach ($fields as $key => $attrs) {
            if ($key != 'id') {
                $this->loadFormField($key, $attrs);
            }
        }
    }

    private function loadFormField($key, $attrs) {
        $formFieldClassFile = $attrs['class'] . "Form.class.php";
        require_once 'forms/fields/' . $formFieldClassFile;
        $className = $attrs['class'] . "Form";
        $this->formFields[$key] = new $className;
    }

    protected function setFieldsAttributes() {
        $modelFields = $this->modelInstance->getFields();
        $modelFieldsObjects = $this->modelInstance->getFieldsObjects();
        foreach ($this->formFields as $key => $field) {

            $field->setStaticAttributes();

            if (array_key_exists($key, $modelFields)) {
                $modelAttrs = $modelFields[$key];

                if (array_key_exists('readable_name', $modelAttrs))
                    $field->setLabel($modelAttrs['readable_name']);
                else {
                    $field->setLabel(slug_to_readable($key));
                }

                $field->setName($key);
                $field->setAttributes($modelAttrs);
                $validator = $modelFieldsObjects[$key]->getValidator();
                $req = $modelFieldsObjects[$key]->getAttribute('required');
                $validator->setConstraint('required', $req);

                // TODO: Wrong because arrayData can be modelInstance...
                if (!is_null($this->arrayData) &&
                        array_key_exists($key, $this->arrayData)) {

                    $validator->setValue($this->arrayData[$key]);
                } else {

                    $validator->setValue($this->modelInstance->getValue($key));

//                    else if (array_key_exists('default_value', $modelAttrs)) {
//                        $validator->setValue($modelAttrs['default_value']);
//                    }
                }
                $field->setValidator($validator);
            }
        }
    }

    public function save() {
        $this->modelInstance->save(true);
    }

}