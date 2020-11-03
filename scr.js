function auth(){
	let xhr = new XMLHttpRequest();
	var login = document.forms.loginForm.login.value;
	var password = document.forms.loginForm.password.value;
	console.log (document.forms.loginForm.login);
	console.log (document.forms.loginForm.password);
	// -----адрес, куда мы отправим нашу JSON-строку-----
	let url = "https://l8.scripthub.ru/api.php?module=auth&login=" + login + "&password=" + password;
	console.log (url);
	// -----открываем соединение-----
	xhr.open("GET", url, true); 
	xhr.setRequestHeader("Content-Type", "application/json"); 
	//-----обработка обращения к серверу-----
	xhr.onreadystatechange = function () { 
	//-----если запрос принят и сервер ответил, что всё в порядке-----
		if (xhr.readyState === 4 && xhr.status === 200) { 
			var answer = this.responseText;
			console.log (answer);
			if (answer == "{\"result\":\"Пароль неверно введен!\"}"){
				alert (answer);
			}
			else {location.replace("calc.php");}
		}	
	}; 
	xhr.send();
}

function reg(){
	let xhr = new XMLHttpRequest();
	var login = document.forms.loginForm.login_reg.value;
	var password = document.forms.loginForm.password_reg.value;
	var password_2 = document.forms.loginForm.password_reg_2.value;	
	console.log (document.forms.loginForm.login);
	console.log (document.forms.loginForm.password);
	// -----адрес, куда мы отправим нашу JSON-строку-----
	let url = "https://l8.scripthub.ru/api.php?module=reg&login_reg=" + login + "&password_reg=" + password + "&password_reg_2=" + password_2;
	console.log (url);
	// -----открываем соединение-----
	xhr.open("GET", url, true); 
	xhr.setRequestHeader("Content-Type", "application/json"); 
	//-----обработка обращения к серверу-----
	xhr.onreadystatechange = function () { 
	//-----если запрос принят и сервер ответил, что всё в порядке-----
		if (xhr.readyState === 4 && xhr.status === 200) { 
			var answer = this.responseText;
			console.log (answer);
			if ((answer == "{\"result\":\"Повторный пароль введен не верно!\"}") || (answer == "{\"result\":\"Пользователь с таким логином существует!\"}")){
				alert (answer);
			}
			else {location.replace("calc.php");}
		}	
	}; 
	xhr.send(); 		
}