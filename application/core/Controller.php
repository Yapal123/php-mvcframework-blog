<?php

namespace application\core;

use application\core\View;

abstract class Controller {

	public $route;
	public $view;
	public $acl;

	public function __construct($route) {
		$this->route = $route;
		//If Acl return false - user will be redirected on error page
		if (!$this->checkAcl()) {
			View::errorCode(403);
		}
		//create object of View class and send route there
		$this->view = new View($route);
		//create object of Model class and send controller there
		$this->model = $this->loadModel($route['controller']);
	}
	//name in this method we got from call from __construct in this class
	public function loadModel($name) {
		//path to current model
		$path = 'application\models\\'.ucfirst($name);
		if (class_exists($path)) {
			return new $path;
		}
	}

	public function checkAcl() {
		$this->acl = require 'application/acl/'.$this->route['controller'].'.php';
		if ($this->isAcl('all')) {
			return true;
		}
		elseif (isset($_SESSION['authorize']['id']) and $this->isAcl('authorize')) {
			return true;
		}
		elseif (!isset($_SESSION['authorize']['id']) and $this->isAcl('guest')) {
			return true;
		}
		elseif (isset($_SESSION['admin']) and $this->isAcl('admin')) {
			return true;
			
		}
		return false;
	}

	public function isAcl($key) {
		return in_array($this->route['action'], $this->acl[$key]);
	}

}