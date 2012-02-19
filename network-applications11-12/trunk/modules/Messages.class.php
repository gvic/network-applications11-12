<?php

class Messages extends AbstractModule {

    protected $messages;

    public function startHook() {
        
    }

    public function addMessage($mess, $class_tag) {
        $html = '<div class="' . $class_tag . '"><ul><li>' . $mess . '</li></ul></div>';
        $this->messages[] = $html;
        $this->controller->d['Messages'][] = $html;
    }

    public function addInfoMessage($mess, $class_tag = 'info') {
        $this->addMessage($mess, $class_tag);
    }

    public function addWarningMessage($mess, $class_tag = 'warning') {
        $this->addMessage($mess, $class_tag);
    }

    public function addErrorMessage($mess, $class_tag = 'error') {
        $this->addMessage($mess, $class_tag);
    }

    public function getMessages() {
        return $this->messages;
    }

    public function terminateHook() {
        
    }

}

?>