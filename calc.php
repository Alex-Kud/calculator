<?php
session_start();

if((isset($_SESSION['auth']) && ($_SESSION['auth'] == false)) || (!isset($_SESSION['auth']))){
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head> 
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Калькулятор</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
    </head>
	
	<body> 
	
		<div class="logout">
		
			<p>Вы вошли под ником: <?php echo $_SESSION['login']?> 😎</p>
			
			<form action="api.php" method="get">
				<button class="button" name="module" value="logout" type="submit">Выйти</button>
			</form>
		</div>

		<div class="calculator"> 
			<form name="form">
				<input class="textview" name="textview" id="test">
			</form>
			
			<div class="cont-buttons"> </div>
				<table class="table table-bordered">
					<tbody>
						<tr>
							<td><input class="button" type="button" value="CE" onclick="clean_chislo()"></td>
							<td><input class="button" type="button" value="C" onclick="clean()"></td>
							<td><input class="button" type="button" value="D" onclick="back()"></td>
							<td><input class="button" type="button" value="/" onclick="input('/')"></td>
						</tr>
						<tr>
							<td><input class="button" type="button" value="7" onclick="input(7)"></td>
							<td><input class="button" type="button" value="8" onclick="input(8)"></td>
							<td><input class="button" type="button" value="9" onclick="input(9)"></td>
							<td><input class="button" type="button" value="*" onclick="input('*')"></td>
						</tr>
						<tr>
							<td><input class="button" type="button" value="4" onclick="input(4)"></td>
							<td><input class="button" type="button" value="5" onclick="input(5)"></td>
							<td><input class="button" type="button" value="6" onclick="input(6)"></td>
							<td><input class="button" type="button" value="-" onclick="input('-')"></td>
						</tr>
						<tr>
							<td><input class="button" type="button" value="1" onclick="input(1)"></td>
							<td><input class="button" type="button" value="2" onclick="input(2)"></td>
							<td><input class="button" type="button" value="3" onclick="input(3)"></td>
							<td><input class="button" type="button" value="+" onclick="input('+')"></td>
						</tr>
						<tr>
							<td><input class="button" type="button" value="±" onclick="znak()"></td>
							<td><input class="button" type="button" value="0" onclick="input(0)"></td>
							<td><input class="button" type="button" value="." onclick="input('.')"></td>
							<td><input class="button" type="button" value="=" onclick="result()">
							</td>
						</tr>
					</tbody>
				</table>
		</div>
		<script src="script.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
	</body>
</html>