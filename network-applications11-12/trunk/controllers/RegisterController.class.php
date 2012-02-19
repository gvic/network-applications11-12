<?php

require_once 'models/UserForm.class.php';
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
        $userForm = new UserForm($this->request['POST']);
        $this->d['form'] = $userForm;
        $this->d['displayForm'] = true;
        if ($this->request['POST']) {
            if ($userForm->isValid()) {
                $mess = $this->getModule('Messages');
                $this->d['displayForm'] = false;
                try {
                    $userForm->save();
                    $mess->addInfoMessage("Your account has been created.");
                    return $this->redirectTo("Index", 
                            array('Messages' => $mess->getMessages()));
                } catch (DuplicateEntryException $e) {
                    $this->d['displayForm'] = true;

                    $mess->addErrorMessage($e->getMessage());
                }
            }
        }


        return $this->renderToTemplate();
    }

}

?>
