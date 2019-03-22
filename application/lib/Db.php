<?php

namespace application\lib;

use PDO;

class Db {

	protected $db;
	//get path to config and PDO connection
	public function __construct() {
		$config = require 'application/config/db.php';
		$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);
	}
	//query method
	public function query($sql, $params = []) {
		//prepeare query for execution
		$stmt = $this->db->prepare($sql);
		if (!empty($params)) {
		//$params are contain variables, we create $params array in every childModel method 
		//Where we need to do any query to DB
			foreach ($params as $key => $val) {
			//PDO need only INT or STRING types for query
				if (is_int($val)) {

					$type = PDO::PARAM_INT;
				} else {
					$type = PDO::PARAM_STR;
				}
				//binding value for execute
				$stmt->bindValue(':'.$key, $val, $type);
			}
		}
		//execute function protect our query from SQL injection
		$stmt->execute();
		return $stmt;
	}
	//return all data
	public function row($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}
	//return only 1 collumn 
	public function column($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchColumn();
	}
	//return ID of last added row in DB
	public function lastInsertId() {
		return $this->db->lastInsertId();
	}

	

}