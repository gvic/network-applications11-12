<?php
require_once 'models/User.class.php';
require_once 'models/UserPicture.class.php';

class GenerateContentController extends AbstractController{
	
	function action(){
		$user = new User();
		$userP = new UserPicture();
		$user->createTable();
		$userP->createTable();
	}
}