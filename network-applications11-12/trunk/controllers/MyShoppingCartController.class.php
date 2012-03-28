<?php

include_once 'models/UserPicture.class.php';

/**
 * Description of MyShoppingCart
 *
 * @author victorinox
 */
class MyShoppingCartController extends AbstractController {

    protected function action() {
        $mod = $this->getModule('Auth');
        $mod->checkAccess();
        $cart = $this->getModule('SessionCart');
        $userPictureModel = new UserPicture();
        if (isset($this->request['GET']['action'])) {
            $param = $this->request['GET'];
            if ($param['action'] == 'delete' && isset($param['id'])) {
                $up = $userPictureModel->get(array('id' => $param['id']));
                $cart->removeItem($up->getValue('media_path'));
            }
        }
        $this->d['items'] = $this->request['SESSION']['CART'];
        $ups = array();
        foreach ($this->d['items'] as $path => $value) {
            $ups[$path] = $userPictureModel->get(array('media_path' => $path));
        }
        $this->d['items'] = $ups;

        return $this->renderToTemplate();
    }

}
