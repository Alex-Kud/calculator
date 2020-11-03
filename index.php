<!DOCTYPE html>
<html>
    <head> 
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Авторизация</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
    </head>

<?php
session_start();
//Пользователь авторизован, редиректим в калькулятор
if(isset($_SESSION['auth']) && $_SESSION['auth'] == true){
		header('Location: calc.php');
}
?>
	<body>
		<div class="container mt-4">
			<div class="row">
				<div class="col">
					<center>
						<h1>Добро пожаловать на наш сайт!</h1>
						<h3>Для того, чтобы воспользоваться калькулятором PSU, авторизируйтесь!</h3>
						<h3>Если Вы здесь впервые, <a href="reg.html">пройдите регистрацию😉</a></h3>
					</center>
				</div>
			</div>
		</div>

		<form class="auth" name="loginForm">
		   <p><input type="text" name="login" placeholder="Логин"></p>
		   <p><input type="password" name="password" placeholder="Пароль"></p>
		   <input class="button" type="button" value="🔑Авторизоваться🔑" onclick="auth()">
		</form>
		<script src="scr.js"></script>
	</body>
</html>

