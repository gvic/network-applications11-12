<?php

class SessionCart extends AbstractModule {

    private $cart;

    public function startHook() {
        $req = $this->controller->getRequest();
        if (array_key_exists('CART', $req['SESSION'])) {
            $this->cart = $req['SESSION']['CART'];
        }
    }

    public function createCart() {
        // associative array id_item => qty item
        if (!is_array($this->cart)) {
            $this->cart = array();
            $this->updateSession();
        }
    }

    public function addItem($key, $value) {
        $this->cart[$key] = $value;
        $this->updateSession();
    }
    
    public function removeItem($key){
        if(array_key_exists($key, $this->cart)){
            unset($this->cart[$key]);
        }
        $this->updateSession();
    }

    protected function updateSession() {
        $this->controller->setSession('CART', $this->cart);
    }

    public function getCart() {
        $this->createCart();
        return $this->cart;
    }

    public function getQty($id) {
        if (array_key_exists($id, $this->cart)) {
            return $this->cart[$id];
        } else {
            return 0;
        }
    }

    public function terminateHook() {
        
    }

}

?>