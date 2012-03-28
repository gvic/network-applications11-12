<?php

require_once 'models/User.class.php';
require_once 'models/UserPictureForm.class.php';
require_once 'models/UserPicture.class.php';

/**
 * Description of AjaxWSInterfaceController
 *
 * @author victorinox
 */
class AjaxWSInterfaceController extends AbstractController {

    protected function action() {
        $xrequest = $this->request['SERVER']['HTTP_X_REQUESTED_WITH'];
        $validContent = ($this->request['SERVER']['REQUEST_METHOD'] == "POST");
        $validContent = ($validContent && isset($this->request['POST']['filepath']));
        /* AJAX check + POST method check */
        if (!(!empty($xrequest) && strtolower($xrequest) == 'xmlhttprequest'
                && $validContent)) {
            return;
        }

        $response = array('error' => null);
        $filepath = $this->request['POST']['filepath'];
        $filename = basename($filepath);
        $imageName = $this->request['POST']['image_name'];
        $data = array(
            'uploaded_file' => '@' . $filepath . ';filename=' . $imageName,
            'frame_name' => $this->request['POST']['frame_name']
        );

        $url = 'http://localhost:8080/CardServiceApp/resources/imaging/fullsize';

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_HEADER, false);
        curl_setopt($c, CURLOPT_POST, true);
        //curl_setopt($c, CURLOPT_FILE, $filepath);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($c);

        if ($output === false) {
            $response['error'] = 'Erreur curl :  ' . curl_error($c);
            echo json_encode($response);
            return;
        }
        if (!curl_errno($c)) {
            curl_close($c);
            $user = new User();
            $user_id = $this->request['SESSION']['user_id'];
            $user->get(array('id' => $user_id));
            $dir = MEDIA . "static/" . $user->getValue('login');
            try {
                $absolutDirPath = ROOT . "/$dir";
                if (!is_dir($absolutDirPath)) {
//                    $media = ROOT . 'media/static/';
//                    chmod($media, 0777);
                    if (!mkdir($absolutDirPath, 0755)) {
                        $response['error'] = "Creation of the directory failed.";
                        echo json_encode($response);
                        return;
                    }
                }

                $filepath = "$absolutDirPath/$filename";
                if (file_exists($filepath)) {
                    $response['error'] = "The same file has been already uploaded.";
                    echo json_encode($response);
                    return;
                }

                $writtenFile = file_put_contents($filepath, $output);
                if (!$writtenFile) {
                    $response['error'] = "File creation failed.";
                    echo json_encode($response);
                    return;
                }

                // user could have 2 options: download the image or order it to be sent in the postal mail
                $media_path = MEDIA . 'static/' . $user->getValue('login') . '/' . $filename;
                $userPictureForm = new UserPictureForm($this->request['POST']);
                $userPictureForm->setFieldValue('media_path', $media_path);
                $userPictureForm->setFieldValue('user', $user);
                $userPictureForm->save(true);
                $cartMod = $this->getModule('SessionCart');
                $pic = new UserPicture();
                $pic->get(array('image_name' => $imageName, 'user' => $user));
                $cartMod->addItem($media_path, $pic);
                $response['image_id'] = $pic->getValue('id');
                $response['image'] = $pic->getValue('media_path');
                echo json_encode($response);
                return;
            } catch (DuplicateEntryException $e) {
                $response['error'] = "This image name already exists in your account space";
                echo json_encode($response);
                return;
            }
            // user could have 2 options: download the image or order it to be sent in the postal mail
        }

        echo json_encode(array('error' => 'An unexpected error occured.'));
        return;
    }

}
