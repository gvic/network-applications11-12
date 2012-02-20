<?php

abstract class AbstractForm {

    private $formAttributes = array();

    /**
     * Associative array storing field label (readable field name to render),
     * form field object, and validation errors array
     * The key is the field name described in the model class
     * @var array
     */
    protected $formFields = array();
    protected $data = array();
    protected $nonFieldsError = "";

    function __construct($data = array()) {
        $this->setFormFields();
        $this->data = $data;
        $this->mapData();
        $this->setFieldsAttributes();
        $this->excludeFields();
        $this->setFormAttributes();
    }

    protected function mapData() {
        foreach ($this->data as $key => $value) {
            if (array_key_exists($key, $this->formFields)) {
                $postFeeding = true;
                $this->formFields[$key]->setValue($value, $postFeeding);
            }
        }
    }

    public function renderFormAttributes() {
        $out = "";
        foreach ($this->formAttributes as $key => $value) {
            $out .= $key . '="' . $value . '" ';
        }
        return $out;
    }

    public function renderAsP() {
        $out = "";
        $i = 0;
        foreach ($this->formFields as $fieldObj) {
            $fieldObj->setAttribute('tabindex', $i++);
            $out .= $fieldObj->renderAsP();
        }
        return $out;
    }

    protected function excludeFields() {
        
    }

    protected function exculdeField() {
        foreach (func_get_args() as $key => $fieldName)
            unset($this->formFields[$fieldName]);
    }

    protected function setFormAttributes() {
        //$this->formAttributes['accept-charset'] = 'UTF-8';
        $this->formAttributes['action'] = '';
        //$this->formAttributes['enctype'] = 'text/plain';
        $this->formAttributes['method'] = 'post';
        foreach ($this->formFields as $name => $field) {
            if ($field->getTagType() == "input" &&
                    $field->getAttribute('type') == "file")
                $this->setFormAttribute("enctype", "multipart/form-data");
        }
    }

    protected function setFieldAttribute($fieldName, $key, $value) {
        $this->formFields[$fieldName]->setAttribute($key, $value);
    }

    public function setFormAttribute($key, $value) {
        $this->formAttributes[$key] = $value;
    }

    abstract protected function setFormFields();

    protected function addFormField($field, $after = null) {
        if (!is_null($after)) {
            $in = array($field->getAttribute('name') => $field);
            $this->formFields = array_push_after($this->formFields, $in, $after);
        } else {
            $this->formFields[$field->getAttribute('name')] = $field;
        }
    }

    protected function setFieldsAttributes() {
        $i = 0;
        foreach ($this->formFields as $key => $field) {
            $field->setStaticAttributes();
            if (array_key_exists($key, $this->data)) {
                $field->setValue($this->data[$key]);
            }
        }
    }

    public function getField($key) {
        return $this->formFields[$key];
    }

    public function isValid() {
        $valid = true;
        foreach ($this->formFields as $key => $fieldObj) {
            if (!$fieldObj->isValid()) {
                $valid = false;
            }
        }
        if ($valid) {
            try {
                $this->validate();
            } catch (Exception $e) {
                $this->nonFieldsError = $e->getMessage();
                $valid = false;
            }
        }
        return $valid;
    }

    abstract protected function validate();

    public function renderNonFieldsError() {
        return $this->nonFieldsError;
    }

}