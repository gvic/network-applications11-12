<?php

require_once 'models/CheckOutForm.class.php';
require_once 'models/User.class.php';

/**
 * Description of CheckOutController
 *
 * @author victorinox
 */
class CheckOutController extends AbstractController {

    protected function action() {
        $auth = $this->getModule('Auth');
        $auth->checkAccess();
        $userM = new User();
        $user = $userM->get(array('id' => $this->request['SESSION']['user_id']));
        $checkOutForm = new CheckOutForm($this->request['POST'], $user);
        $this->d['form'] = $checkOutForm;
        return $this->renderToTemplate();
    }

}
