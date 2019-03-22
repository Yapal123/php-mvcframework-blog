<?php

namespace application\core;

use application\lib\Db;

abstract class Model {

	public $db;
	//connecting to DataBase
	public function __construct() {
		$this->db = new Db;
	}

}