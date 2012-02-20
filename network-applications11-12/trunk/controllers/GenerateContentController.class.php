<?php
require_once 'models/User.class.php';
require_once 'models/UserPicture.class.php';

class GenerateContentController extends AbstractController{
	
	function action(){
		$user = new User();
		$userP = new UserPicture();
		$user->createTable();
		$userP->createTable();

//		$data_user = array(
//		array('first_name'=>'Victorinox','last_name'=>'Godayere','password'=>'42b5','email'=>"godayerv@gmail.com"),
//		array('first_name'=>'Sakura','last_name' => 'Komiya'),
//		array('first_name'=>'Geir',),
//		array('first_name'=>'Therence',),
//		);
//		
//		try{
//			$user->create($data_user);
//		}catch(Exception $e){}
	}
}