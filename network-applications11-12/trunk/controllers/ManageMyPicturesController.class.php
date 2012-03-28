<?php

require_once 'models/UserPicture.class.php';
require_once 'db/CriteriaBuilder.class.php';

/**
 * Description of ManageMyPicture
 *
 * @author victorinox
 */
class ManageMyPicturesController extends AbstractController {

    protected function action() {
        $mod = $this->getModule('Auth');
        $mod->checkAccess();
        $up = new UserPicture();
        if (isset($this->request['GET']['action'])) {
            $param = $this->request['GET'];
            if ($param['action'] == 'delete' && isset($param['id'])) {
                try {
                    $up->get(array('id' => $param['id']));
                    $up->deleteIt();
                } catch (NoEntryException $e) {
                    $mess = $this->getModule('Messages');
                    $mess->addWarningMessage("The file you try to delete doesn't exist in database");
                }
            }
        }

        $cb = new CriteriaBuilder();
        $cb->where('user_id', '=', $this->request['SESSION']['user_id']);

        $ups = $up->find($cb);
        $this->setData('pics', $ups);
        return $this->renderToTemplate();
    }

}
