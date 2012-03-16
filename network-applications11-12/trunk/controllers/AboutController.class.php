<?php

class AboutController extends AbstractController {

    public function action() {
        $this->d['title'] = 'Assessment Project Team Information';
        return $this->renderToTemplate();
    }

}

?>