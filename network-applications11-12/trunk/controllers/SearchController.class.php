<?php
require_once 'models/UserPicture.class.php';
require_once 'db/CriteriaBuilder.class.php';

class SearchController extends AbstractController {

    public function action() {
        if (isset($this->request['GET']['keywords'])) {
            $pics = new UserPicture();
            $cb = new CriteriaBuilder();
            $keywords = $this->request['GET']['keywords'];
            $cb->where('image_name', ' LIKE ', "%$keywords%");
            $pics = $pics->find($cb);
            $this->d['pics'] = $pics;
            return $this->renderToTemplate();
        } else {
            return $this->redirectTo('Index');
        }
    }

}

?>