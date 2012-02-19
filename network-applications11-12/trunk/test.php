<?php 

require_once 'conf/bootstrap.php';
require_once 'models/User.class.php';
require_once 'models/UserPicture.class.php';
require_once 'models/UserForm.class.php';
require_once 'models/UserPictureForm.class.php';

$cb = new CriteriaBuilder();
$user = new User();
$userPicture = new UserPicture();

$user->createTable();
$userPicture->createTable();




/*$data = array('login'=>'victor','email'=>'Germain',);
$data2 = array('login'=>'geir','password'=>'test gap');
$user->create(array($data,$data2));*/



$data = array('login'=>'geir');
$u = $user->get($data);

$u->update(array('password'=>'42b564oq')); // clear all data non updated...
$data = array('user'=>$u);
//$userPicture->create($data);
$up = $userPicture->get(array('path'=>'path'));
$up->update(array('user'=>$u));

$cb = new CriteriaBuilder();
$cb->where('user', '=', $u);
/*$ups = $up->find($cb);
foreach ($ups as $upp) {
	echo $upp;
}*/


$form = new UserPictureForm();
echo "<form ".$form->renderFormAttributes().">";
echo $form->renderAsP();
echo "</form>";

/**$data = array(
	array('first_name'=>'Jim','last_name'=>'Harrison'),
	array('first_name'=>'Ernest','last_name'=>'Hemingway'),
	array('first_name'=>'Nicolas','last_name'=>'Bouvier'),
	array('first_name'=>'Jane','last_name'=>'Austen'),
);
$author->create($data);*/


//$author->delete(array('first_name'=>array('Jim','Ernest'),'last_name'=>'Bouvier'));
/*$cb->where('id', '>', 8);
$a1 = $author->find($cb);
foreach ($a1 as $auth) {
	 echo "$auth, ";
	 $auth->deleteIt(true);
}
$a2 = $author->get(array('first_name'=>'Ernest'));*/
//$a1->deleteAll(true);
//$a->update(array('first_name'=>'Victor'));// Manage with foreignkey..



//$book->get(array('title'=>'titre modifie'))->update(array('title'=>'titre modifiee'));
// enconding to manage now....

//echo $book->getRelated('author');
//$book->update(array('author'=>$a,'publisher'=>'hehehe'));
//echo $book->getDBScheme();

/**
 $data = array(
 array('title'=>'titre de test 15', 'publisher'=>'bidon','author'=>$a1, 'subject'=>'bidon',),
 array('title'=>'titre de test 16', 'publisher'=>'bidon2','author'=>$a2, 'subject'=>'bidon',)
 );
 $book->create($data);
 */




