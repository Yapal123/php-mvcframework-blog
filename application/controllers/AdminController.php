<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Main;

class AdminController extends Controller {

	public function __construct($route) {
		//get access to current route
		parent::__construct($route);
		//set layout for admin panel
		$this->view->layout = 'admin';
		
	}
	public function avaAction(){

		if (!empty($_POST)) {

			if(!empty($_FILES['ava']['tmp_name'])){
				
				$this->model->avaUploadImage($_FILES['ava']['tmp_name'], $_SESSION['username']);
			}
			
		}
		
		$this->view->redirect('admin/user');
	}
	public function userAction(){

			$this->view->render('User, hai');
		
	}
	public function loginAction() {
		//check if user is admin
		if (isset($_SESSION['admin'])) {
			$this->view->redirect('admin/add');
		}
		if (!empty($_POST)) {
			//validating of correct insert
			if ($this->model->loginValidate($_POST)) {
				//error if incorrect
				$_SESSION['admin'] = 1;
			$this->view->location('admin/add');

			} elseif(!$this->model->loginAll($_POST)) {
				$this->view->message('Error','Incorrect login or password');
			} 
				$this->model->loginAll($_POST);
				
				$_SESSION['authorize'] = 1;
				$_SESSION['username'] = $_POST['login'];
				$this->view->location('main/index/1');

			
			
			
		}
		$this->view->render('Войдите');
	}

	public function registerAction(){
		if(isset($_SESSION['authorize'])){
			$this->view->redirect('');
		}
		if (!empty($_POST)) {
			if (!$this->model->regValidate($_POST)) {
				$this->view->message('Error',$this->model->error);
			}
			if ($this->model->checkReg($_POST) >= 1) {
				$this->view->message('error', 'user is already exist');
			}
			$this->model->doRegistration($_POST);
			$_SESSION['authorize'] = 1;
			$_SESSION['username'] = $_POST['name'];
			$this->view->location('main/index/1');

		}

		$this->view->render('Ясно, хуета');
		
	}
	//add post
	public function addAction() {
		if (!empty($_POST)) {
			//validating of post
			if (!$this->model->postValidate($_POST,'add')) {
				$this->view->message('Error',$this->model->error);
			}
			$id = $this->model->postAdd($_POST);
			//check if postAdd return false
			if(!$id){
				$this->view->message('Error','Somwthing wrong');
			}
			//post add return last insert ID of post and ID is name for image of post
			$this->model->postUploadImage($_FILES['img']['tmp_name'],$id);
			$this->view->message('Success','Posted');
			
		}

		$this->view->render('Добавить пост');
	}

	public function editAction() {
		//check if post with current ID exist
		if(!$this->model->isPostExist($this->route['id'])){
			$this->view->errorCode(404);
		}
		if (!empty($_POST)) {
			if (!$this->model->postValidate($_POST,'edit')) {
				$this->view->message('Error',$this->model->error);
			}
			$this->model->postEdit($_POST,$this->route['id']);
			if ($_FILES['img']['tmp_name']) {
				$this->model->postUploadImage($_FILES['img']['tmp_name'], $this->route['id']);
			}
			$this->view->message('Success','OK');

		}
		//data is first array row
		$vars = [
			'data' => $this->model->postData($this->route['id'])[0]
		];
		$this->view->render('Редактировать пост',$vars);
	}

	public function deleteAction() {
		if(!$this->model->isPostExist($this->route['id'])){
			$this->view->errorCode(404);
		}
		$this->model->postDelete($this->route['id']);
		$this->view->redirect('admin/posts');
	}

	public function logoutAction() {
		unset($_SESSION['admin']);
		unset($_SESSION['authorize']);
		unset($_SESSION['username']);

		$this->view->redirect('');
	}

	public function postsAction() {
		$mainModel = new Main;
		$pagination = new Pagination($this->route, $mainModel->postCount());
		$vars = [
			'pagination' =>$pagination->get(),
			'list' =>$mainModel->postList($this->route),
		];
		$this->view->render('Posts',$vars);
		
	}
}