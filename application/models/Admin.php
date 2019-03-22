<?php

namespace application\models;

use application\core\Model;
use Imagick;


class Admin extends Model {

	public $error;

	public function loginValidate($post) {
		$config = require 'application/config/admin.php';
		if ($config['login'] != $post['login'] or $config['password'] != $post['password']) {
			$this->error = 'Incorrect data';
			return false;
		}
		return true;
	}

	public function loginAll($post){
		$params = [
			'name' => $post['login'],
			'password' => $post['password'],

		];

		return $this->db->column("SELECT count(id) FROM Users WHERE name = :name and password = :password ",$params);
	}

	public function regValidate($post){
		$name = iconv_strlen($post['name']);
		$password = iconv_strlen($post['password']);
		$password1 = iconv_strlen($post['password1']);

		if ($name < 2 or $name > 20) {
			$this->error = 'Ваш ник должен содержать от 2 до 20 символов';
			return false;
		} elseif ($password < 6 ) {
			$this->error = 'Пароль слишком коротокий, должен быть не менее 6 символов';
			return false;
		} elseif ($post['password'] != $post['password1']) {
			$this->error = 'Пароли не совпадают';
			return false;
		}return true;

			
	}


	public function checkReg($post){
		$params = [
			'name' => $post['name'],	
		];
		return $this->db->column('SELECT COUNT(id) FROM Users WHERE name = :name',$params);
	}
	public function doRegistration($post){
		$params = [
			'id' => '',
			'name' => $post['name'],
			'password' =>$post['password'],
		];

		return $this->db->query("INSERT INTO Users VALUES (:id, :name,:password)",$params);
	}



	public function postValidate($post,$type){
		$nameLen = iconv_strlen($post['title']);
		$descriptionLen = iconv_strlen($post['description']);
		$textLen = iconv_strlen($post['text']);
		if ($nameLen < 3 or $nameLen > 100) {
			$this->error = 'Название должно содержать от 3 до 20 символов';
			return false;
		} elseif ($descriptionLen < 10 or $descriptionLen > 500) {
			$this->error = 'Описание должно содержать от 50 до 500 символов';
			return false;
		} elseif ($textLen < 100) {
			$this->error = 'Текст должен содержать от 100  символов';
			return false;
		}


	
			/*if (empty($_FILES['img']['tmp_name']) and $type == 'add') {
				$this->error = 'File does not pick';
				return false;
			}*/
		

		return true;
		}

		//get post from current controller
		public function postAdd($post){
			$params = [
				'id' =>'',
				'description' => $post['description'],
				'title' => $post['title'],
				'text' => $post['text'],
			];
		
			$this->db->query('INSERT INTO `posts` VALUES (:id, :title, :description, :text)', $params);
			return $this->db->lastInsertId();

		}
		//get params from current controller
		public function postEdit($post,$id){
			$params = [
				'id' =>$id,
				'description' => $post['description'],
				'title' => $post['title'],
				'text' => $post['text'],
			];
		
			$this->db->query('UPDATE posts SET description = :description, title = :title, text = :text WHERE id = :id', $params);
			

		}


		public function postUploadImage($path, $id){
			$img = new Imagick($path);
			//cropping of size
			$img->cropThumbnailImage(1024,1024);
			//Quality compresiion
			$img->setImageCompressionQuality(80);
			//Load img on server to current folder with name of ID of post
			$img->writeImage($_SERVER['DOCUMENT_ROOT'].'/public/materials/'.$id.'.jpg');
	
		}

		public function avaUploadImage($path,$name){
			$image = new Imagick($path);

			//cropping of size
			$image->cropThumbnailImage(100,100);
			//Quality compresiion
			$image->setImageCompressionQuality(80);
			//Load img on server to current folder with name of ID of post
			$image->writeImage($_SERVER['DOCUMENT_ROOT'].'/public/materials/ava/'.$name.'.jpg');
		}
		//check if post exist
		public function isPostExist($id){
			$params = [
				'id' => $id];
			return $this->db->column('SELECT id FROM posts WHERE id = :id',$params);
		}
		//delete post
		public function postDelete($id){
			$params = [
				'id' => $id];

			 $this->db->query('DELETE  FROM posts WHERE id = :id',$params);
			 //delete img from server 
			 unlink($_SERVER['DOCUMENT_ROOT'].'/public/materials/'.$id.'.jpg');
		}

		//get current post
		public function postData($id){
			$params = [
				'id' => $id];
				
			return $this->db->row('SELECT * FROM posts WHERE id = :id',$params);	
		}

		

	}

	
	

