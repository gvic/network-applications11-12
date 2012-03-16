<?php

require_once 'models/UserPicture.class.php';
require_once 'db/CriteriaBuilder.class.php';

/**
 * Description of ManageMyPicture
 *
 * @author victorinox
 */
class ManageMyPicturesController extends AbstractController {

    protected function action() {
        $mod = $this->getModule('Auth');
        $mod->checkAccess();
		$up = new UserPicture();       
        if (isset($this->request['GET']['action'])) {
            $param = $this->request['GET'];
            if ($param['action'] == 'delete' && isset($param['id'])) {
	      try{
		rmdir('/u1/msc/vg55/public_html/na/media/static/voodoofox/');
		$up->get(array('id' => $param['id']));
		$up->deleteIt();
	      } catch(NoEntryException $e){
		$mess = $this->getModule('Messages');
		$mess->addWarningMessage("The file you try to delete doesn't exist in database");
	      }
            }
        }

	$cb = new CriteriaBuilder();
	$cb->where('user_id','=',$this->request['SESSION']['user_id']);

	$ups = $up->find($cb);

        if ($this->request['POST']) {
            foreach ($ups as $key => $model) {
                $id = $model->getValue('id');
                $bool = false;
                if (isset($this->request['POST']['private_' . $id])) {
                    $bool = true;
                }
                $up->get(array('id' => $id));
                $model->update(array('private' => $bool));
            }
        }

        $this->setData('pics', $ups);
        return $this->renderToTemplate();
    }

}
