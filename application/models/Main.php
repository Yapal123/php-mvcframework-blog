<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

	public $error;

	public function contactValidate($post) {
		$nameLen = iconv_strlen($post['name']);
		$textLen = iconv_strlen($post['text']);
		if ($nameLen < 3 or $nameLen > 20) {
			$this->error = 'Имя должно содержать от 3 до 20 символов';
			return false;
		} elseif (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error = 'E-mail указан неверно';
			return false;
		} elseif ($textLen < 10 or $textLen > 500) {
			$this->error = 'Сообщение должно содержать от 10 до 500 символов';
			return false;
		}
		return true;
	}

	public function postCount(){
		return $this->db->column('SELECT COUNT(id) FROM posts ');
	}

	public function postList($route){
		$max = 4;
		$params = [
			'max' => $max,
			'start' => ( ( $route['page']  ?? 1 ) - 1 ) * $max,
		];
		return $this->db->row('SELECT * FROM posts ORDER BY id DESC LIMIT :start, :max',$params);
	}

	public function postSelect($id){
		$params = [
			'id' => $id];
		return $this->db->row('SELECT * FROM posts WHERE id = :id',$params);
	}

	public function showComments($id){
		$params = [
			'id' => $id
		];
		return $this->db->row('SELECT * FROM comments WHERE postId = :id',$params);
	}
	public function commentValidate($post){
		if ($post['text'] > 1000) {
			$this->error = 'Сообщение должно содержать  до 1000 символов';
			return false;
		}
		return true;
	}

	public function postComment($post){
		$params = [
			'id' => '',
			'text' => $post['text'],
			'name' => $post['name'],
			'postId' => $post['postId'],
		];
		
		return $this->db->query("INSERT INTO comments VALUES (:id,:text, :name,:postId)", $params);
	}
}