<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;

class MainController extends Controller {

	public function indexAction() {
		

		$pagination = new Pagination($this->route, $this->model->postCount());
		$vars = [
			'pagination' =>$pagination->get(),
			'list' =>$this->model->postList($this->route),

		];
		$this->view->render('Главная страница', $vars);
	}

	public function aboutAction() {
		$this->view->render('Обо мне');
	}

	public function contactAction() {
		if (!empty($_POST)) {
			//validating of correct insert
			if (!$this->model->contactValidate($_POST)) {
				//error if incorrect
				$this->view->message('error', $this->model->error);
			}
			mail('yapalq@gmail.com', 'Сообщение из блога', $_POST['name'].'|'.$_POST['email'].'|'.$_POST['text']);
			$this->view->message('success', 'Сообщение отправлено Администратору');
		}
		$this->view->render('Контакты');
	}

	public function postAction() {

		$vars = [
			'data' =>$this->model->postSelect($this->route['id'])[0],
			'comments'=>$this->model->showComments($this->route['id']),
		];
		$this->view->render('Пост',$vars);
	}

	public function commentAction(){
		if (!empty($_POST)) {
			if (!$this->model->commentValidate($_POST)) {
				$this->view->message('error', $this->model->error);
			}
			//$id = preg_replace('\\', '', $_POST['postId']);
			$id = $_POST['postId'];
			$this->model->postComment($_POST);
			
		}
		$this->view->location('post/'.$id);
	}
}