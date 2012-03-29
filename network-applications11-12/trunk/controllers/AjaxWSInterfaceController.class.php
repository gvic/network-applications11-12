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
        $image_name = $this->request['POST']['image_name'];
        $frame_name = $this->request['POST']['frame_name'];

        $c = curl_init();
        $images = $this->createImages($c, $filepath, $image_name, $frame_name);
        $thumb = $images['thumbsize'];
        $full = $images['fullsize'];

        if (is_null($images)) {
            $response['error'] = 'Erreur curl :  ' . curl_error($c);
            echo json_encode($response);
            return;
        }
        if (!curl_errno($c)) {
            curl_close($c);
            $user = new User();
            $user_id = $this->request['SESSION']['user_id'];
            $user->get(array('id' => $user_id));
            $media_path = MEDIA . "static/" . $user->getValue('login');
            try {
                $absolutDirPath = ROOT . "/$media_path";
                $filepath = "$absolutDirPath/$filename";
                $thumbFilePath = "$absolutDirPath/thumb_$filename";
                if (file_exists($filepath)) {
                    $response['error'] = "The same file has been already uploaded.";
                    echo json_encode($response);
                    return;
                }

                $writtenFile = file_put_contents($filepath, $full);
                $writtenFile = $writtenFile && file_put_contents($thumbFilePath, $thumb);
                if (!$writtenFile) {
                    $response['error'] = "File creation failed.";
                    echo json_encode($response);
                    return;
                }

                // user could have 2 options: download the image or order it to be sent in the postal mail
                $media_file_path = $media_path . '/' . $filename;
                $thumb_media_file_path = $media_path . '/thumb_' . $filename;
                $userPictureForm = new UserPictureForm($this->request['POST']);
                $userPictureForm->setFieldValue('media_path', $media_file_path);
                $userPictureForm->setFieldValue('user', $user);
                $userPictureForm->setFieldValue('thumbnail_media_path', $thumb_media_file_path);
                $userPictureForm->save(true);
                $cartMod = $this->getModule('SessionCart');
                $pic = new UserPicture();
                $pic->get(array('image_name' => $image_name, 'user' => $user));
                $cartMod->addItem($pic->getValue('id'), $pic);
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

    protected function createImages($c, $file_path, $image_name, $frame_name) {
        $data = array(
            'uploaded_file' => '@' . $file_path . ';filename=' . $image_name,
            'frame_name' => $frame_name
        );

        $url = 'http://localhost:8080/CardServiceApp/resources/imaging/imageservice/fullsize';

        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_HEADER, false);
        curl_setopt($c, CURLOPT_POST, true);
        //curl_setopt($c, CURLOPT_FILE, $filepath);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

        $fullsize = curl_exec($c);

        if ($fullsize === false)
            return null;

        $url = 'http://localhost:8080/CardServiceApp/resources/imaging/imageservice/thumbsize';

        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_HEADER, false);
        curl_setopt($c, CURLOPT_POST, true);
        //curl_setopt($c, CURLOPT_FILE, $filepath);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

        $thumbsize = curl_exec($c);

        if ($thumbsize === false)
            return null;

        return array('fullsize' => $fullsize, 'thumbsize' => $thumbsize);
    }

}
