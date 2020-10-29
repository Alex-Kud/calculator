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
//-----Новый объект api класса SimpleAPI-----
$api = new SimpleAPI();
//-----Пользователь авторизован, редиректим в калькулятор-----
if($_SESSION['auth'] == true){
	header('Location: calc.php');
}
//-----При клике клавиши Авторизоваться обращение к свойству module и присваивание ему значения auth. $_GET['auth'] приходит из index.php-----
if(isset( $_GET['auth'])){
    $api->module = 'auth';
}
//-----При клике клавиши Регистрации обращение к свойству module и присваивание ему значения reg. $_GET['reg'] приходит из index.php-----
if(isset( $_GET['reg'])){
    $api->module = 'reg';
}
//-----При клике клавиши Выйти обращение к свойству module и присваивание ему значения logout. $_GET['logout'] приходит из calc.php-----
if(isset( $_GET['logout'])){
    $api->module = 'logout';
}
//Попытка работы с функцией rezult из script.js
if($_POST['param']) {
 $param = json_decode($_POST['param']);
 $row = eval ($param);
 echo json_encode($row);
 exit();
}

switch ($api->module){
	//-----Кейс для авторизации-----
    case 'auth':
        $data = $api->params(['login', 'password']);
		$api->answer['authorize'] = ($data['login'] == 'admin' && $data['password'] == 'admin'); //это для проверки работоспособности
		//-----Создаём массив для сбора ошибок-----
		$errors = array();
		$lgn = $_GET['login'];
		//-----Проводим поиск пользователей в таблице users-----
		$user = $db->query('SELECT * FROM `users` WHERE `login` = ?s', ['$lgn']); 
		$array = json_encode($user, true); 
		//-----Если логин существует, тогда проверяем пароль-----
		if(isset($array)){
			if($_GET['password'] == $array->password){
				//-----Все верно, пускаем пользователя-----
				$_SESSION['auth'] = true;
				$_SESSION['login'] = $_GET['login'];
				//-----Редирект на главную страницу-----
				header('Location: calc.php');
				//-----Пароль неверен - выдаём ощибку-----
			}else {$errors[] = 'Пароль неверно введен!';}
		//-----Если такого пользователя нет в БД - выдаём ошибку-----
		}else {$errors[] = 'Пользователь с таким логином не найден!';}
		//-----Выводим ошибки, стирая их из массива-----
		if(!empty($errors)){
			echo array_shift($errors);
		}
        break;
	//-----Кейс для регистрации-----
    case 'reg':
        $data = $api->params(['login_reg', 'password_reg', 'password_reg_2']);
		$api->answer['authoreg'] = ($data['login_reg'] == 'admin' && $data['password_reg'] == 'admin' && $data['password_reg'] == $data['password_reg_2']); //это для проверки работоспособности
			//-----Создаем массив для сбора ошибок-----
			$errors = array();
			//-----Проводим проверки-----
			if(trim($_GET['login_reg']) == ''){
				$errors[] = "Введите логин!";
			}
			if($_GET['password_reg'] == ''){
				$errors[] = "Введите пароль";
			}
			if($_GET['password_reg_2'] == ''){
				$errors[] = "Введите повторный пароль";
			}			
			if($_GET['password_reg_2'] != $_GET['password_reg']){
				$errors[] = "Повторный пароль введен не верно!";
			}
			//функция mb_strlen - получает длину строки
			if(mb_strlen($_GET['login_reg']) < 5 || mb_strlen($_GET['login_reg']) > 90){
				$errors[] = "Недопустимая длина логина";
			}
			if(mb_strlen($_GET['password_reg']) < 2 || mb_strlen($_GET['password_reg']) > 8){
				$errors[] = "Недопустимая длина пароля (от 2 до 8 символов)";
			}
			//-----Проверка на уникальность логина-----
			$database = $db->query('SELECT * FROM `users` WHERE `login` = ?s', [$_GET['login_reg']]);
			$my_array = json_encode($database, true); 
			echo $my_array;
			if($my_array->login != ' '){ 
				$errors[] = "Пользователь с таким логином существует!";
			}
			//-----Если ошбок нет, то заполняем БД и говорим, что всё ОК-----
			$lg = $_GET['login_reg'];
			$rg = $_GET['password_reg'];
			if(empty($errors)) {
				$db->query('INSERT INTO users (login, password) VALUES (?as)', ['$lg', '$rg']);
				echo 'Вы успешно зарегистрированы! Можно авторизоваться';
			//-----Если есть ошибки, выводим их-----	
			} else {
				// array_shift() извлекает первое значение массива array и возвращает его, сокращая размер array на один элемент. 
				echo array_shift($errors);
			}
        break;
	//-----Кейс для выхода-----		
    case 'logout':
	    $data = $api->params(['?login', '?password']);
		//-----Производим выход пользователя-----
		unset($_SESSION['auth']);
		unset($_SESSION['login']);
		//-----Редирект на главную страницу-----
		header('Location: index.php');
}