<?php
class Database {

	var $dbms;
	var $host;
	var $user;
	var $passwd;
	var $name;

	public function Database() {
		$this->dbms = DBMS;
		$this->host = DBHOST;
		$this->user = DBUSER;
		$this->passwd = DBPASSWD;
		$this->name = DBNAME;
	}
}

