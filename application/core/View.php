<?php

namespace application\core;

class View {

	public $path;
	public $route;
	public $layout = 'default';
	// we got $route from parrent controller
	public function __construct($route) {
		$this->route = $route;
		//path to current view, where controller is a folder and action is file
		$this->path = $route['controller'].'/'.$route['action'];
	}
	//get 2 params, $title - text, which you need to put in title, in current view
	//and $vars - array of any data
	public function render($title, $vars = []) {
		extract($vars);
		//root path to view
		$path = 'application/views/'.$this->path.'.php';
		//check if current view exist
		if (file_exists($path)) {
			ob_start();
			require $path;
			$content = ob_get_clean();
			//require of layout
			require 'application/views/layouts/'.$this->layout.'.php';
		}
	}
	//redirect method
	public function redirect($url) {
		header('location: /'.$url);
		exit;
	}
	//this method is redirecting on $code page, $code we getting from childController
	public static function errorCode($code) {
		http_response_code($code);
		$path = 'application/views/errors/'.$code.'.php';
		if (file_exists($path)) {
			require $path;
		}
		exit;
	}
	//Ajax message
	public function message($status, $message) {
		exit(json_encode(['status' => $status, 'message' => $message]));
	}
	//Ajax redirect
	public function location($url) {
		exit(json_encode(['url' => $url]));
	}

}	