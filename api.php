<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once "DataBase-master/autoload.php"; //Подключаем библиотеки
require_once "simple-api-master/autoload.php";

use DigitalStars\DataBase\DB;
use DigitalStars\SimpleAPI;

header('Access-Control-Expose-Headers: Access-Control-Allow-Origin', false);
header('Access-Control-Allow-Origin: *', false);
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept', false);
header('Access-Control-Allow-Credentials: true');
//-----Подключение к БД-----
$db_type = 'mysql';
$db_name = 'learner8';
$login = 'learner8';
$pass = '3vlMv4S7TFn9fazGcjAS';
$ip = 'localhost';
//-----Создание экземпляра к БД------
$db = new DB("mysql:host=localhost;dbname=$db_name", $login, $pass,
    [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
//-----Запуск сессии-----
session_start();
$api = new SimpleAPI();
//-----Пользователь авторизован, редиректим в калькулятор-----
if(isset($_SESSION['auth']) && $_SESSION['auth'] == true){
	header('Location: calc.php');
}

//Попытка работы с функцией rezult из script.js
if(isset($_POST['param'])) {
 $param = json_decode($_POST['param']);
 $row = eval ($param);
 $json = json_encode($row);
}

switch ($api->module){
	//-----Кейс для авторизации-----
    case 'auth':
        $data = $api->params(['login', 'password']);
		//-----Если логин и пароль верны, пускаем в калькулятор-----
		$row = $db->row("SELECT * FROM users WHERE login = ?s AND password =?s", [$data['login'], $data['password']]);
		if ($row){
			$_SESSION['auth'] = true;
			$_SESSION['login'] = $data['login'];
			header('Location: calc.php');
		} else {
			echo 'Пароль неверно введен!';
			echo "<a href=\"index.php\">Повторите попытку</a>"; //Выводит всё как текст без разметки и ссылки. Хотя при вставке в calc.php разметка и ссылка работают
		}
	break;
	//-----Кейс для регистрации-----
    case 'reg':
        $data = $api->params(['login_reg', 'password_reg', 'password_reg_2']);
			//-----Создаем массив для сбора ошибок-----
			$errors = array();
			//-----Проводим проверки-----
			if(trim($data['login_reg']) == ''){
				$errors[] = "Введите логин!";
			}
			if($data['password_reg'] == ''){
				$errors[] = "Введите пароль";
			}
			if($data['password_reg_2'] == ''){
				$errors[] = "Введите повторный пароль";
			}			
			if($data['password_reg_2'] != $data['password_reg']){
				$errors[] = "Повторный пароль введен не верно!";
			}
			//-----Проверка на уникальность логина-----
			$row_reg = $db->row("SELECT * FROM users WHERE login = ?s", [$data['login_reg']]);
			if($row_reg){ 
				$errors[] = "Пользователь с таким логином существует!";
			}
			//-----Если ошбок нет, то заполняем БД и редиректим в калькулятор-----
			if(empty($errors)) {
				$db->query("INSERT INTO users (login, password) VALUES (?s, ?s)", [$data['login_reg'], $data['password_reg']]);
				$_SESSION['auth'] = true;
				$_SESSION['login'] = $data['login_reg'];
				header('Location: calc.php');	
			//-----Если есть ошибки, выводим их-----	
			} else {
				echo array_shift($errors);
			}
        break;
	//-----Кейс для выхода-----		
    case 'logout':
		session_destroy();
		header('Location: index.php');
}
?>