<?php

require_once 'models/UserPicture.class.php';
require_once 'db/CriteriaBuilder.class.php';

/**
 * Description of LastPictures
 *
 * @author victorinox
 */
class LastPictures extends AbstractModule{

    public function startHook() {
        $qb = new CriteriaBuilder();
        $qb->orderBy('-id')->limit(5);
        $lastUP = new UserPicture();
        $lastUP = $lastUP->find($qb);
        $this->controller->setData('last_pictures',$lastUP);
    }

    public function terminateHook() {
        return;
    }
}

