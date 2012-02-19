<?php

require_once 'models/User.class.php';
require_once 'models/AccountForm.class.php';
require_once 'db/exceptions/DuplicateEntryException.class.php';

/**
 * Description of RegisterContrller
 *
 * @author victorinox
 */
class MyAccountDetailsController extends AbstractController {

    protected function action() {
        $userM = new User();
        $user = $userM->get(array('id'=>  $this->request['SESSION']['user_id']));
        $userForm = new AccountForm($this->request['POST'],$user);
        $this->d['form'] = $userForm;
        if ($this->request['POST']) {
            if ($userForm->isValid()) {
                $mess = $this->getModule('Messages');
                try {
                    $userForm->save();
                    $mess->addInfoMessage("Your account has been updated.");
                    return $this->redirectTo("Index", 
                            array('Messages' => $mess->getMessages()));
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
