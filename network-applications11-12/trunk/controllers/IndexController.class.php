<?php

require_once 'models/User.class.php';
require_once 'models/UserPicture.class.php';

class IndexController extends AbstractController {

    public function action() {
        $this->d['title'] = 'Welcome on PicUp!';
        return $this->renderToTemplate();
    }

}

?>