<?php


// Database informations
define('DATABASE_HOST', 	'localhost'		);
//define('DATABASE_HOST', 	'mysql-server-1');
define('DATABASE_NAME',		'picup'	);
//define('DATABASE_NAME',		'vg55'		);
define('DATABASE_USER', 	'root'			);
//define('DATABASE_USER', 	'vg55'			);
define('DATABASE_PWD', 		'******'		);
//define('DATABASE_PWD', 		'vg55'		);
define('DATABASE_TYPE', 	'mysql'			);
define('DATABASE_ENGINE',	'InnoDB'		);
define('DATABASE_CHARSET',	'latin1'		);

// Root directory where the application is stored.
define('ROOT',				'/var/www/picup/trunk/');

// Path of the media directory
define('MEDIA',				ROOT.'/media');


// Extend the include path in order to get
// rid of the prefix when calling  'include' and 'require' functions
$conf_path = PATH_SEPARATOR.ROOT.'/conf';
//$template_path = PATH_SEPARATOR.ROOT.'/views';
$template_path = PATH_SEPARATOR.ROOT.'views/includes';
$controllers_path = PATH_SEPARATOR.ROOT.'/controllers';
$modules_path = PATH_SEPARATOR.ROOT.'/modules';
//$models_path = PATH_SEPARATOR.ROOT.'/models';
$models_fields_path = PATH_SEPARATOR.ROOT.'/models/fields';
//$res = set_include_path(get_include_path().$conf_path.$template_path.$controllers_path.$modules_path.$models_fields_path);
$res = set_include_path(get_include_path().$template_path);
