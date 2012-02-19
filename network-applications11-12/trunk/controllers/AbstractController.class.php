<?php

require_once 'utils/utils.php';

abstract class AbstractController {

    // array containing all the super global
    protected $request;
    // arrays filled with clean data for sql statment
    // when clean<token> method is called.
    protected $cookieCleaned;
    protected $getCleaned;
    protected $postCleaned;
    // array containing the object modules loaded.
    protected $modules;
    // template variable
    public $d;

    function __construct() {
        $this->request = array();
        $this->cookieCleaned = array();
        $this->getCleaned = array();
        $this->postCleaned = array();
        $this->modules = array();
        $this->d = array();
    }

    // Setter used from the bootstrap file
    public function setRequest(array $array) {
        foreach ($array as $key => $value) {
            $this->request[$key] = $value;
        }
        $this->d['title'] = caseSwitchToSpaces($this->request['GET']['c']);
    }

    // Getter used for the modules
    public function getRequest() {
        return $this->request;
    }

    // Method containing the business logic.
    // To be implemented in the subclasses 
    // extending this abstract class.
    abstract protected function action();

    // Hook called from the index.php
    // Performs common and recurrent tasks about the
    // session data, the loading of the modules and their hooks
    public function processRequest() {
        $this->loadModules();
        foreach ($this->request['SESSION'] as $key => $value) {
            $this->d[$key] = $value;
        };
        $this->action();
        $this->terminateHookModules();
        foreach ($this->request['SESSION'] as $key => $value) {
            if ($key != "persist" && !in_array($key, $this->request['SESSION']['persist'])) {
                unset($this->request['SESSION'][$key]);
            }
        }
        $_SESSION = $this->request['SESSION'];
    }

    private function terminateHookModules() {
        foreach ($this->modules as $key => $value) {
            $value->terminateHook();
        }
    }

    // Wrapper for the cleadData method
    protected final function cleanPost($constraint = array('all' => 'required')) {
        $this->postCleaned = $this->cleanDatas($this->request['POST'], $constraint);
        return $this->postCleaned;
    }

    // Wrapper for the cleadData method
    protected final function cleanGet($constraint = array('all' => 'required')) {
        $this->getCleaned = $this->cleanDatas($this->request['GET'], $constraint);
        return $this->getCleaned;
    }

    // Wrapper for the cleadData method
    protected final function cleanCookie($constraint = array('all' => 'required')) {
        $this->cookieCleaned = $this->cleanDatas($this->request['COOKIE'], $constraint);
        return $this->cookieCleaned;
    }

    // Clean data in order to make them ready to be stored in a database
    // through a sql statment.
    // A very restraint constraint feature is allowed to be passed in parameter
    // Concretly it only allows to put a 'required' constraint on every element
    // of the array iterated
    protected function cleanDatas($arr, $constraint) {
        foreach ($arr as $key => $value) {
            if (get_magic_quotes_gpc()) {
                $value = stripslashes($value);
            }
//            if (!is_numeric($value)) {
//                $value = mysql_real_escape_string($value);
//            }
            $value = trim($value);
            if ($value == "" && array_key_exists('all', $constraint) &&
                    $constraint['all'] == 'required') {
                throw new Exception("All the fields are required");
            }
            $arr[$key] = $value;
        }
        return $arr;
    }

    // Instantiate a module according the naming standard
    // from a given module name
    // Also execute the startHook 
    private function loadModule($moduleName) {
        $classFile = $moduleName . '.class.php';
        require_once 'modules/' . $classFile;
        $mod = new $moduleName;
        $this->modules[$moduleName] = $mod;
        $this->modules[$moduleName]->setController($this);
        $this->modules[$moduleName]->startHook();
    }

    // Wrapper to load all the modules declared
    // in the bootstrap file
    private function loadModules() {
        foreach ($GLOBALS['modules'] as $value) {
            $this->loadModule($value);
        }
    }

    // Retrieves a module object and instantiate it 
    // if it is not yet.
    public function getModule($name) {
        if (!array_key_exists($name, $this->modules)) {
            $this->loadModule($name);
        }
        return $this->modules[$name];
    }

    // Retrieves a model object
    // DEPRECATED
    protected function getModel($name) {
        $className = ucfirst(strtolower($name)) . "Model";
        $classFile = $className . ".class.php";
        require_once 'models/' . $classFile;
        $model = new $className;
        return $model;
    }

    // Method with "infinite args" capacity.
    // Args are key of the d attribute. If the key does 
    // not exist then it initializes this array entry.
    public function initializeData() {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!array_key_exists($arg, $this->d))
                $this->d[$arg] = '';
        }
    }

    // Setter for the template variable d.
    public function setData($key, $value) {
        $this->d[$key] = $value;
    }

    // Includes the template according the the 
    // super global parameter c if no template name is passed
    // as argument of the function.
    public function renderToTemplate($template = null) {
        $d = $this->d;
        if ($template == null) {
            $template = $this->request['GET']['c'] . '.php';
        }
        require_once "views/$template";
    }

    // Redirect from the current url to the 
    // one corresponding th the controller name
    // Possibility to pass data from the current page to the next one.
    // Also, get params can be passed as an associative array
    public function redirectTo($controllerName, $dataToPass = array(), $getParam = array()) {

        // Clean the session data which are not meant to be persistent
        foreach ($this->request['SESSION'] as $key => $value) {
            if ($key != "persist" && !in_array($key, $this->request['SESSION']['persist'])) {
                unset($this->request['SESSION'][$key]);
            }
        };
        if (!empty($dataToPass)) {
            foreach ($dataToPass as $key => $value) {
                $this->passData($key, $value);
            }
        }

        // Copy back to the native super globals.
        $_GET = $this->request['GET'];
        $_SESSION = $this->request['SESSION'];

        // Generate the string for the given array of get params=>values
        $params = (!empty($getParam)) ? $this->formatGetParam($getParam) : '';
        header("Location: index.php?c=" . $controllerName . $params);
        exit; // In order to avoid execution of code following the header statment.
    }

    // Deprecated ? Coder can provide the formated string himself.
    // But can be source of more coding errors...
    private function formatGetParam(array $arr_params) {
        $params = "";
        foreach ($arr_params as $key => $value) {
            $params .= "&" . urldecode($key) . "=" . urlencode($value);
        }
        return $params;
    }

    // To add session data only for the next page
    public function passData($key, $value) {
        $this->request['SESSION'][$key] = $value;
    }

    // To add session data persistently
    public function setSession($key, $val) {
        $this->passData($key, $val);
        if (!array_key_exists("persist", $this->request['SESSION'])) {
            $this->request['SESSION']["persist"] = array();
        }
        if (!array_key_exists($key, $this->request['SESSION']["persist"])) {
            $this->request['SESSION']["persist"][] = $key;
        }
    }

    // Empty the copy of given the super global key  
    public function resetGlobal($key) {
        $this->request[$key] = array();
    }

    // Empty all the super global copies
    private function resetGlobals() {
        foreach ($this->request as $key => $value) {
            $this->resetGlobal($key);
        }
    }

}

?>
