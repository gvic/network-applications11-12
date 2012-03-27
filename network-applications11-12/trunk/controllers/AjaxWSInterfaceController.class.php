<?php

/**
 * Description of AjaxWSInterfaceController
 *
 * @author victorinox
 */
class AjaxWSInterfaceController extends AbstractController {

    protected function action() {
        $xrequest = $this->request['SERVER']['HTTP_X_REQUESTED_WITH'];
        /* AJAX check + POST method check */
        if (!empty($xrequest) && strtolower($xrequest) == 'xmlhttprequest') {

            // Check if the user is allowed to perform this action.
            $mod = $this->getModule('Auth');
            if (!$mod->isAuth()) {
                $mess = $this->getModule('Messages');
                $mess->addWarningMessage("Login or register before starting upload!");
                return $this->redirectTo('Login', array('Messages' => $mess->getMessages()));
            }


            $validContent = ($this->request['SERVER']['REQUEST_METHOD'] == "POST");
            $validContent = ($validContent && isset($this->request['POST']['filename']));
            if ($validContent) {
                $response = array('error' => null);
                $filename = $this->request['POST']['filename'];
                $filepath = "/tmp/$filename";
                $data = array(
                    'uploaded_file' => '@' . $filepath . ';filename=' . $filename,
                    'frame_name' => $this->request['POST']['frame_name']
                );
                $url = 'http://www2.macs.hw.ac.uk:8180/CardServiceApp/resources/imaging/fullsize';

                $c = curl_init();
                curl_setopt($c, CURLOPT_URL, $url);
                curl_setopt($c, CURLOPT_HEADER, false);
                curl_setopt($c, CURLOPT_POST, true);
                // curl_setopt($c, CURLOPT_FILE, $imagedata);
                curl_setopt($c, CURLOPT_POSTFIELDS, $data);
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

                //$output = curl_exec($c);
                $output = false;

                if ($output === false) {
                    //trigger_error('Erreur curl : ' . curl_error($c), E_USER_WARNING);
                    $error = 'Erreur curl :  ' . curl_error($c) . "<br/>";
                    $error .= print_a($data, true);
                    $response['error'] = $error;
                } elseif (!curl_errno($c)) {
                    $user = new User();
                    $user->get(array('id' => $this->request['SESSION']['user_id']));
                    $dir = MEDIA . "/static/" . $user->getValue('login');
                    $mess = $this->getModule('Messages');
                    try {
                        $createdDir = true;
                        $absolutDirPath = ROOT . "/$dir";
                        if (!is_dir($absolutDirPath)) {
                            $media = ROOT . '/media/static/';
                            chmod($media, 0777);
                            $createdDir = mkdir($absolutDirPath, 0755);
                        }
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
                            $userPictureForm = new UserPictureForm();
                            $userPictureForm->setFieldValue('media_path', $media_path);
                            $userPictureForm->setFieldValue('user', $user);
                            $pic = $userPictureForm->save();
                            $cartMod = $this->getModule('SessionCart');
                            $cartMod->addItem($pic->getValue('media_path', $pic));

                            $response['image_id'] = $pic->getValue('id');
                            $response['image'] = $pic->getValue('media_path');
                        } else {
                            $response['error'] = "Fail in directory creation or file writing.";
                        }
                    } catch (DuplicateEntryException $e) {
                        $response['error'] = "This image name already exists into your account space";
                    }

                    // user could have 2 options: download the image or order it to be sent in the postal mail
                    curl_close($c);
                }
                echo json_encode($response);
            } else {
                return;
            }
        } else {
            return;
        }
    }

}
