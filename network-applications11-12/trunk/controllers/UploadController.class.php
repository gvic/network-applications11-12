<?php

require_once 'models/UserPictureForm.class.php';
require_once 'models/User.class.php';
require_once 'db/exceptions/DuplicateEntryException.class.php';
require_once 'utils/utils.php';

/**
 * Description of RegisterContrller
 *
 * @author victorinox
 */
class UploadController extends AbstractController {

    protected function action() {
        $mod = $this->getModule('Auth');
        if (!$mod->isAuth()) {
            $mess = $this->getModule('Messages');
            $mess->addWarningMessage("Login or register before starting upload!");
            return $this->redirectTo('Login', array('Messages' => $mess->getMessages()));
        }
        $this->d['include_preview'] = true;

        //$userPictureForm->setFormAttribute('action', '?c=Upload');
        $method = $this->request['SERVER']['REQUEST_METHOD'];
        if ($method == "GET") {
            $t = '<input type="hidden" name="photoset" value="false" id="hide_uploaded"/>';
            $t .= '<br /><h4>Select photo</h4><br />';
            $this->d['photoset_input'] = $t;
            $this->d['form'] = new UserPictureForm ();
        } elseif ($method == "POST" && !empty($this->request['FILES'])) {
            $userPictureForm = new UserPictureForm($this->request['POST'], null, $this->request['FILES']);
            if ($userPictureForm->isValid()) {

                $t = '<input type="hidden" name="photoset" value="true" id="hide_uploaded"/>';
                $t .= '<br /><h4>Photo have been selected! Click below if you want to use another photo.</h4><br />';
                $this->d['photoset_input'] = $t;

                $file = $this->request['FILES']['media_path'];
                $user = new User();
                $user->get(array('id' => $this->request['SESSION']['user_id']));
                $filename = basename($file['name']);
                $t = '<input type="hidden" name="photopath" value="' . $filename . '" id="photo_name">';
                $this->d['photopath_input'] = $t;
                move_uploaded_file($file["tmp_name"], "/tmp/" . $filename);
            } else {
                $t = '<input type="hidden" name="photoset" value="false" id="hide_uploaded"/>';
                $t .= '<br /><h4>Select photo</h4><br />';
                $this->d['photoset_input'] = $t;
            }
            $this->d['form'] = $userPictureForm;
        }

        return $this->renderToTemplate();
    }

}

?>
