<?php
require_once 'utils/utils.php';
require_once 'db/exceptions/DBExceptionManager.class.php';

class Database{

	private $link_id;
	private $sql;
	private $result;
	private $dbExceptionManager;


	public function __construct(){
		$this->connect(DATABASE_HOST, DATABASE_USER, DATABASE_PWD);
		$this->select_db(DATABASE_NAME);
		$this->cleanSql();
		$this->dbExceptionManager = new DBExceptionManager();
	}

	public function __destruct(){
		//mysql_close($this->link_id);
		// Error: 14 is not a valid MySQL-Link resource
		//mysql_close();
		// Error:  no MySQL-Link resource supplied
	}

	protected function connect($host, $name, $pass) {
		$this->link_id = mysql_connect($host, $name, $pass) or die(mysql_error());
		return $this;
	}
	protected  function select_db($databasename) {
		mysql_select_db($databasename) or die(mysql_error());
		return $this;
	}

	public function setStatment($sql){
		$this->sql = $sql;
		return $this;
	}

	private function cleanSql(){
		$this->sql = "";
		return $this;
	}

	public function executeQuery(){
		$this->result = mysql_query($this->sql) or $this->dbExceptionManager->throwException(mysql_errno(),mysql_error());
		return $this;
	}

	public function count(){
		return mysql_num_rows($this->result);
	}

	public function fetcArray(){
		return mysql_fetch_array($this->result);
	}
	
	public function fetchAssoc(){
		return mysql_fetch_assoc($this->result);
	}

	public function close(){
		return mysql_close($this->link_id) or die(mysql_errno());
	}
}
