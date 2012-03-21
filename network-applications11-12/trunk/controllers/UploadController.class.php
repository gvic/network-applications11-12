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

        $userPictureForm = new UserPictureForm($this->request['POST'], null, $this->request['FILES']);
        //$userPictureForm->setFormAttribute('action', '?c=Upload');
        $this->d['form'] = $userPictureForm;
        if ($this->request['FILES']) {
            if ($userPictureForm->isValid()) {
                // Business code

                $file = $this->request['FILES']['media_path'];
                $imagedata = $file["tmp_name"];
                $user = new User();
                $user->get(array('id' => $this->request['SESSION']['user_id']));
                //$filename = basename($file['name']);
                $split = explode('.', basename($file['name']));
                $ext = $split[count($split) - 1];
                $filename = slugify($this->request['POST']['image_name']) . '.' . $ext;
                ;
                $dir = MEDIA . "/static/" . $user->getValue('login');


                // I will add more information to this array soon, like what frame graphics has been chosen,
                // and if this is a smaller (thumbnail) preview request, or a request for the full size image.
                // I need to be done with the HTML first for that.	
                $data = array('uploaded_file' => '@' . $imagedata . ';filename=' . $filename);

                $url = 'www2.macs.hw.ac.uk:8180/CardServiceApp/resources/imaging/fullsize';

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
                        $createdDir = true;
                        $absolutDirPath = ROOT . "/$dir";
                        if (!is_dir($absolutDirPath)) {
                            $media = ROOT . '/media/static/';
                            chmod($media, 0777);
                            $createdDir = mkdir($absolutDirPath, 0755);
                        }
                        // write the file out to the users own/unique directory (created on registration for each user),
                        // with a order id dir or order date dir for this mage (suggestion).
                        // If its just a thumbnail then it should be cleaned up afterwards.
                        $writtenFile = false;

                        if ($createdDir) {
                            $filepath = "$absolutDirPath/$filename";
                            if (file_exists($filepath)) {
                                $mess->addErrorMessage("The same file has already been uploaded");
                            } else {
                                $writtenFile = file_put_contents($filepath, $output);
                            }
                        }

                        // user could have 2 options: download the image or order it to be sent in the postal mail
                        if ($createdDir && $writtenFile) {
                            $media_path = MEDIA . '/static/' . $user->getValue('login') . '/' . $filename;
                            $userPictureForm->setFieldValue('media_path', $media_path);
                            $userPictureForm->setFieldValue('user', $user);
                            $pic = $userPictureForm->save();
                            $cartMod = $this->getModule('SessionCart');
                            $cartMod->addItem($pic->getValue('media_pat', $pic));
                            $mess->addInfoMessage("Your image has been uploaded.");
                            curl_close($c);
                            return $this->redirectTo("ManageMyPictures", array('Messages' => $mess->getMessages()));
                        } else {
                            $mess->addErrorMessage("Fail in directory creation or file writing.");
                            curl_close($c);
                            return $this->redirectTo("Upload", array('Messages' => $mess->getMessages()));
                        }
                    } catch (DuplicateEntryException $e) {
                        $txt = "This image name already exists into your account space";
                        $mess->addErrorMessage($txt);
                        curl_close($c);
                    }
                }
            }
        }
        return $this->renderToTemplate();
    }

}

?>
