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
            $this->d['photoset_input'] = null;
            $this->d['form'] = new UserPictureForm ();
        } elseif ($method == "POST" && !empty($this->request['FILES'])) {
            $userPictureForm = new UserPictureForm($this->request['POST'], null, $this->request['FILES']);
            if ($userPictureForm->isValid()) {

                $this->d['photoset_input'] = true;

                $imageName = $this->request['POST']['image_name'];
                $this->d['image_name'] = '<input type="hidden" name="image_name" value="' . $imageName . '" id="image_name_id"/>';

                $file = $this->request['FILES']['media_path'];

                $user = new User();
                $user->get(array('id' => $this->request['SESSION']['user_id']));
                
                $filepath = "/tmp/" . basename($file['name']);
                $this->d['photopath'] = $filepath;

                move_uploaded_file($file["tmp_name"], $filepath);
            } 
            $this->d['form'] = $userPictureForm;
        }

        return $this->renderToTemplate();
    }

}

?>
