<?php

require_once 'models/User.class.php';
require_once 'models/ChangePasswordForm.class.php';

/**
 * Description of ChangePasswordController
 *
 * @author victorinox
 */
class ChangePasswordController extends AbstractController {

    //put your code here
    protected function action() {
        $mod = $this->getModule('Auth');
        $mod->checkAccess();
        $userM = new User();
        $user = $userM->get(array('id' => $this->request['SESSION']['user_id']));
        $form = new ChangePasswordForm($this->request['POST'], $user);
        $this->d['form'] = $form;
        if ($this->request['POST']) {
            if ($form->isValid()) {
                $mess = $this->getModule('Messages');
                try {
                    $user->update(array('password'=>$form->getField('new_password')->getValue()));
                    $mess->addInfoMessage("Your account has been updated.");
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
