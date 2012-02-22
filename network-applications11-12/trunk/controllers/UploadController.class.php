<?php

require_once 'models/UserPictureForm.class.php';
require_once 'models/User.class.php';
require_once 'db/exceptions/DuplicateEntryException.class.php';

/**
 * Description of RegisterContrller
 *
 * @author victorinox
 */
class UploadController extends AbstractController {

    protected function action() {
        $mod = $this->getModule('Auth');
        $mod->checkAccess();

        $userPictureForm = new UserPictureForm($this->request['POST'], null, $this->request['FILES']);
        $this->d['form'] = $userPictureForm;
        if ($this->request['POST']) {
            if ($userPictureForm->isValid()) {
                // Business code

                $file = $this->request['FILES']['path'];
                $imagedata = $file["tmp_name"];
                $user = new User();
                $user->get(array('id' => $this->request['SESSION']['user_id']));
                $filename = basename($file['name']);
                $dir = MEDIA . "/static/" . $user->getValue('login');
                $filepath = $dir . "/$filename";

                // I will add more information to this array soon, like what frame graphics has been chosen,
                // and if this is a smaller (thumbnail) preview request, or a request for the full size image.
                // I need to be done with the HTML first for that.	
                $data = array(
                    'uploaded_file' => '@' . $imagedata . ';filename=' . $filename,
                );
                // will change this uri as soon as I get the glassfish server up
                $url = 'http://localhost:8080/CardServiceApp/resources/imaging/fullsize';

                $c = curl_init();
                curl_setopt($c, CURLOPT_URL, $url);
                curl_setopt($c, CURLOPT_HEADER, false);
                curl_setopt($c, CURLOPT_POST, true);
                curl_setopt($c, CURLOPT_POSTFIELDS, $data);
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

                $output = curl_exec($c);

                if ($output === false)
                    trigger_error('Erreur curl : ' . curl_error($c), E_USER_WARNING);

                if (!curl_errno($c)) {
                    $info = curl_getinfo($c);

                    $mess = $this->getModule('Messages');
                    try {
                        $createDir = mkdir($dir, 0777);
                        //if ($createDir) {
                        $userPictureForm->setFieldValue('path', $filepath);
                        $userPictureForm->setFieldValue('user', $user);
                        $userPictureForm->save();
                        $mess->addInfoMessage("Your account has been created.");
//                    } else {
//                        $mess->addErrorMessage("Fail in directory creation.");
//                    }
                        exit;
                        return $this->redirectTo("Index", array('Messages' => $mess->getMessages()));
                    } catch (DuplicateEntryException $e) {
                        $txt = "This image name already exists into your account space";
                        $mess->addErrorMessage($txt);
                    }

                    // write the file out to the users own/unique directory (created on registration for each user),
                    // with a order id dir or order date dir for this mage (suggestion).
                    // If its just a thumbnail then it should be cleaned up afterwards.
                    file_put_contents($filename, $output);

                    // user could have 2 options: download the image or order it to be sent in the postal mail
                    //echo "<img src='$filename' alt='photo' />";
                }

                curl_close($c);
            }
        }


        return $this->renderToTemplate();
    }

}

?>
