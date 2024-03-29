<?php

// We start the session in order to deal with the super global $_SESSION
session_start();

$DEBUG = true;
$errLevel = ($DEBUG) ? E_ALL : E_ERROR;
error_reporting($errLevel);


// We load the settings
require_once 'conf/settings.php';

// We requires these 3 abstract classes in order to be able
// to instatiate any of their subclasses.
require_once 'modules/AbstractModule.class.php';
require_once 'models/AbstractModel.class.php';
require_once 'controllers/AbstractController.class.php';

// List of the default modules to be load by the abstract controller
$modules = array(
    'Messages', 'Auth', 'SessionCart', //'LastPictures',
);

// If the parameter c is not defined yet, we set it to point on the IndexController.
if (!isset($_GET['c'])) {
    $_GET['c'] = 'Index';
}

// According the defined naming standard we load the appropriate controller.
$controllerName = $_GET['c'] . 'Controller';
$controllerClassFile = $controllerName . '.class.php';
require_once 'controllers/' . $controllerClassFile;
// Instantiation
$controller = new $controllerName;

$request = array(
    'SERVER' => $_SERVER,
    'GET' => $_GET,
    'POST' => $_POST,
    'FILES' => $_FILES,
    'COOKIE' => $_COOKIE,
    'SESSION' => $_SESSION,
    'REQUEST' => $_REQUEST,
    'ENV' => $_ENV
);

function selfURL() {
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}

function strleft($s1, $s2) {
    return substr($s1, 0, strpos($s1, $s2));
}
$fullUrl = selfURL();

// Set the request attribute of the instantiated controller 
$controller->setRequest($request);
?>
