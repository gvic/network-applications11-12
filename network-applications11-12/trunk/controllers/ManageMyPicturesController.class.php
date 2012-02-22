<?php

require_once 'models/UserPicture.class.php';

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
                $up->get(array('id' => $param['id']));
                $up->deleteIt();
            }
        }

        $ups = $up->all();

        if ($this->request['POST']) {
            foreach ($ups as $key => $model) {
                $id = $model->getValue('id');
                $bool = false;
                if (isset($this->request['POST']['private_' . $id])) {
                    $bool = true;
                }
                $up->get(array('id' => $id));
                $model->update(array('private' => $bool));
            }
        }

        $this->setData('pics', $ups);
        return $this->renderToTemplate();
    }

}
