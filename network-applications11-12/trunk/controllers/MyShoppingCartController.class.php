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
        $cartModule = $this->getModule('SessionCart');
        $userPictureModel = new UserPicture();        
        if (isset($this->request['GET']['action'])) {
            $param = $this->request['GET'];
            if ($param['action'] == 'delete' && isset($param['id'])) {
                $up = $userPictureModel->get(array('id' => $param['id']));
                $cartModule->removeItem($param['id']);
            }
            if ($param['action'] == 'add' && isset($param['id'])) {
                $cartModule->addItem($param['id'],$param['id']);
            }
        }
        
        $cart = $cartModule->getCart();
        $ups = array();
        foreach ($cart as $id => $idPic) {
            try{
                $ups[$id] = $userPictureModel->get(array('id' => $id));
            }  catch (NoEntryException $e){}
        }
        $this->d['items'] = $ups;

        return $this->renderToTemplate();
    }

}
