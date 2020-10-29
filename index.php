<!DOCTYPE html>
<html>
    <head> 
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Калькулятор</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="test.css">
		
		<link rel="icon" href="favicon.ico" type="image/x-icon">
    </head>

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

$db_type = 'mysql';
$db_name = 'learner8';
$login = 'learner8';
$pass = '3vlMv4S7TFn9fazGcjAS';
$ip = 'localhost';

$db = new DB("$db_type:host=$ip;dbname=$db_name", $login, $pass,
    [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
);

session_start();
//Пользователь авторизован, редиректим в калькулятор
if($_SESSION['auth'] == true){
	header('Location: calc.php');
}

?>

	<body>
		<div class="container mt-4">
			<div class="row">
				<div class="col">
					<center>
						<h1>Добро пожаловать на наш сайт!</h1>
						<h3>Для того, чтобы воспользоваться калькулятором PSU, зарегистрируйтесь!</h3>
						<h3>Если Вы уже зарегистрированы в системе, просто пройдите авторизацию;)</h3>
					</center>
				</div>
			</div>
		</div>



		<form class="auth" action="api.php" method="get">
		   <p><input type="text" name="login" placeholder="Логин"></p>
		   <p><input type="password" name="password" placeholder="Пароль"></p>
		   <button class="btn btn-success" name="auth" type="submit">Авторизоваться</button>
		</form>
		<br>
		<br>
		<form class="reg" action="api.php" method="get">
		   <p><input type="text" name="login_reg" placeholder="Логин"></p>
		   <p><input type="password" name="password_reg" placeholder="Пароль"></p>
		   <p><input type="password" name="password_reg_2" placeholder="Повторите пароль"></p>   
		   <button class="btn btn-success" name="reg" type="submit">Регистрация</button>
		</form>
	</body>
</html>

