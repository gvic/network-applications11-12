<?php

class UserPicture extends AbstractModel {

    protected $fields = array(
        'user' => array('class' => 'ForeignKeyField', 'related_model' => 'User'),
        'path' => array('class' => 'FileField',),
        'thumbnail_path' => array('class' => 'FileField', 'required' => false),
        'image_name' => array('class' => 'TextField',),
        'private' => array('class' => 'BooleanField', 'readable_name' => 'Private access', 'default_value' => true),
    );
    protected $uniqueness = array('user', 'image_name');

    public function toString() {
        return $this->getValue("user") . ": " . $this->getValue('path');
    }

}