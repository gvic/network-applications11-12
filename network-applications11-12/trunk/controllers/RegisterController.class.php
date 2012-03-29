<?php

require_once 'models/RegisterForm.class.php';
require_once 'db/exceptions/DuplicateEntryException.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterContrller
 *
 * @author victorinox
 */
class RegisterController extends AbstractController {

    protected function action() {
        $mod = $this->getModule('Auth');
        if ($mod->isAuth())
            return $this->redirectTo('MyAccountDetails');
        $userForm = new RegisterForm($this->request['POST']);
        $this->d['form'] = $userForm;
        if ($this->request['POST']) {
            if ($userForm->isValid()) {
                $mess = $this->getModule('Messages');
                try {
                    $userForm->save();
                    $mess->addInfoMessage("Your account has been created.");
                    return $this->redirectTo("Index", array('Messages' => $mess->getMessages()));
                } catch (DuplicateEntryException $e) {
                    $txt = "An user with the same login or email already exists";
                    $mess->addErrorMessage($txt);
                }
            }
        }


        return $this->renderToTemplate();
    }

}

?>
