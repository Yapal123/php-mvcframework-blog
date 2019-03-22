<?php

return [
	// MainController


	/*
	Route need to contain the controllerName/actionName
	'Route/{id}' => [
		'controller' => 'ContollerName',
		'action' => 'ActionName',
	], 

	*/




	'' => [
		'controller' => 'main',
		'action' => 'index',
	],
	
	'main/index/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'index',
	],
	'main/comment' => [
		'controller' => 'main',
		'action' => 'comment',
	],
	'about' => [
		'controller' => 'main',
		'action' => 'about',
	],
	'contact' => [
		'controller' => 'main',
		'action' => 'contact',
	],
	'post/{id:\d+}' => [
		'controller' => 'main',
		'action' => 'post',
	],
	// AdminController
	'admin/login' => [
		'controller' => 'admin',
		'action' => 'login',
	],
	'admin/ava' => [
		'controller' => 'admin',
		'action' => 'ava',
	],
	'admin/logout' => [
		'controller' => 'admin',
		'action' => 'logout',
	],
	'admin/register' =>[
		'controller' =>'admin',
		'action' => 'register',
	],
	'admin/add' => [
		'controller' => 'admin',
		'action' => 'add',
	],
	'admin/edit/{id:\d+}' => [
		'controller' => 'admin',
		'action' => 'edit',
	],
	'admin/delete/{id:\d+}' => [
		'controller' => 'admin',
		'action' => 'delete',
	],
	'admin/posts/{page:\d+}' => [
		'controller' => 'admin',
		'action' => 'posts',
	],
	'admin/posts' => [
		'controller' => 'admin',
		'action' => 'posts',
	],
	'admin/user' => [
		'controller' => 'admin',
		'action' => 'user',
	],
];