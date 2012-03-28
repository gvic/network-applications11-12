<?php
require_once 'models/UserPicture.class.php';
require_once 'db/CriteriaBuilder.class.php';

class LatestPicturesController extends AbstractController {

    public function action() {
        $userP = new UserPicture();
        $cb = new CriteriaBuilder();
        $cb->orderBy('-id')->limit(10);
        $pics = $userP->find($cb);
        $this->setData('pics', $pics);
        return $this->renderToTemplate();
    }

}

?>