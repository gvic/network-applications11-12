<?php

require_once 'models/LoginForm.class.php';
require_once 'models/User.class.php';

/**
 * Description of LoginController
 *
 * @author victorinox
 */
class LoginController extends AbstractController {

    //put your code here
    protected function action() {

        $loginForm = new LoginForm($this->request['POST']);
        if ($this->request['POST']) {
            if ($loginForm->isValid()) {
                $post = $this->request['POST'];
                $userModel = new User();
                $encryptedPass = sha1(PREFIX_SALT . $post['password'] . SUFFIX_SALT);
                $criteria = array(
                    'login' => $post['login'],
                    'password' => $encryptedPass
                );
                try {
                    $mod = $this->getModule('Messages');
                    $user = $userModel->get($criteria);
                    $id = $user->getValue('id');
                    $this->getModule('Auth')->authenticate(array('user_id' => $id));
                    $mod->addInfoMessage('You are now logged in.');
                    $cartMod = $this->getModule('SessionCart');
                    $cartMod->createCart();
                    return $this->redirectTo('Index', array('Messages' => $mod->getMessages()));
                } catch (NoEntryException $e) {
                    $mod->addErrorMessage('Your login or password is wrong.');
                }
            }
        }
        $this->d['form'] = $loginForm;

        return $this->renderToTemplate();
    }

}

?>
