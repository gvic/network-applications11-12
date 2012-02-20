<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyAccountController
 *
 * @author victorinox
 */
class MyAccountController extends AbstractController {

    //put your code here
    protected function action() {
        $mod = $this->getModule('Auth');
        $mod->checkAccess();
        return $this->renderToTemplate();
    }

}

?>
