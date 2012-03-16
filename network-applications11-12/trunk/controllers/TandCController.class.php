<?php

class TandCController extends AbstractController {

    public function action() {
        $this->d['title'] = 'Terms and Conditions';
        return $this->renderToTemplate();
    }

}

?>