<?php

require_once 'models/User.class.php';
require_once 'models/UserPicture.class.php';

class IndexController extends AbstractController {

    public function action() {
        // If the user is logged (Auth module) include
        // the customer details page.
        if ($this->getModule('Auth')->isAuth()) {
            return $this->redirectTo('MyAccount');
        } else {
            // Otherwise include the login page with 
            // the link to the register page.
            $this->d['title'] = 'Welcome on PicUp!';
            $template = "Index.php";
        }
        // To triger which menu item must be shown as active
        // thanks to css class .active
        $this->d['active'] = 'Home';
        $cb = new CriteriaBuilder();
        $user = new User();
        //$user->create(array('login'=>'Victorinox','email'=>'test','password'=>'t',
        //'validated'=>true,'created_at'=>'2012-02-14'));
        $userP = new UserPicture();
        return $this->renderToTemplate($template);
    }

}

?>