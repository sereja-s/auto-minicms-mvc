<?php
session_start();
header("Content-Type:text/html;charset=UTF-8");

require_once("config.php"); //Конструкция однократных включений

spl_autoload_register(function ($c) {
	if (file_exists("controller/" . $c . ".php")) {
		require_once "controller/" . $c . ".php";
	} elseif (file_exists("model/" . $c . ".php")) {
		require_once "model/" . $c . ".php";
	}
});

//isset - определяет, установлена ли переменная.
//if (isset($_GET['option']) && !empty($_GET['option']))
if (($_GET['option'])) {
	$class = trim(strip_tags($_GET['option'])); //trim - удаляет из начала и конца строки
} else {
	$class = 'main';
}

//class_exists - Проверяет, был ли объявлен класс
if (class_exists($class)) {

	$obj = new $class;
	$obj->get_body($class);
} else {
	exit("<p>Нет данные для входа</p>");
}
