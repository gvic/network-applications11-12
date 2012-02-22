<?php

class UserPicture extends AbstractModel {

    protected $fields = array(
        'user' => array('class' => 'ForeignKeyField', 'related_model' => 'User'),
        'media_path' => array('class' => 'FileField', 'readable_name' => 'Image file'),
        'thumbnail_media_path' => array('class' => 'FileField', 'required' => false,),
        'image_name' => array('class' => 'TextField',),
        'private' => array('class' => 'BooleanField', 'readable_name' => 'Private access', 'default_value' => true),
    );
    protected $uniqueness = array('user', 'image_name');

    public function toString() {
        return $this->getValue("user") . ": " . $this->getValue('media_path');
    }

    public function deleteIt($cascade = false) {
        // We need to delete physical the file
        $absPath = ROOT . "/" . $this->getValue('media_path');
        $absPath2 = ROOT . "/" . $this->getValue('thumbnail_media_path');
        unlink($absPath);
        if (file_exists($absPath2) && !is_dir($absPath2))
            unlink($absPath2);
        parent::deleteIt($cascade);
    }

}