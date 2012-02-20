<?php

class LogoutController extends AbstractController {

    public function action() {
        $mess = $this->getModule('Auth')->logout();
        return $this->redirectTo("Index", array('Messages' => $mess));
    }

}

?>