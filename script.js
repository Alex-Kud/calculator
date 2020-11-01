var s = 0;
var s2 = 0;

function keyboard(e){
	if(s>s2){
		s2++;
		document.form.textview.value="";
	}
    switch(e.keyCode){
        case 48: document.form.textview.value = document.form.textview.value+'0'; break;
        case 49: document.form.textview.value = document.form.textview.value+'1'; break;
		case 50: document.form.textview.value = document.form.textview.value+'2'; break;
		case 51: document.form.textview.value = document.form.textview.value+'3'; break;
		case 52: document.form.textview.value = document.form.textview.value+'4'; break;
		case 53: document.form.textview.value = document.form.textview.value+'5'; break;
		case 54: document.form.textview.value = document.form.textview.value+'6'; break;
		case 55: document.form.textview.value = document.form.textview.value+'7'; break;
		case 56: document.form.textview.value = document.form.textview.value+'8'; break;
		case 57: document.form.textview.value = document.form.textview.value+'9'; break;
        case 43: document.form.textview.value = document.form.textview.value+'+'; break;
        case 45: document.form.textview.value = document.form.textview.value+'-'; break;
		case 42: document.form.textview.value = document.form.textview.value+'*'; break;
		case 47: document.form.textview.value = document.form.textview.value+'/'; break;
		case 61: result(); break;
		case 13: result(); break;
		case 44: document.form.textview.value = document.form.textview.value+'.'; break;
    }
}
addEventListener("keypress", keyboard);

function input(chislo){
	if(s>s2){
		s2++;
		document.form.textview.value="";
	}
		document.form.textview.value = document.form.textview.value+chislo;
}

function sendJSON() { 
	let xhr = new XMLHttpRequest(); 
	var send_string = document.form.textview.value;
	send_string = send_string.replace(/([+])/g, '$1 !');
	//Нужно из send_string выделить первое число, знак операции !-*/, второе число
	var var1 = "";
	var operator = "";
	var var2 = "";
	var arr = [];
	arr = send_string.split('');
	var flag = 0;
	console.log ('Строка: ', send_string);

	console.log ('Длина строки: ', send_string.length);

	for (let i = 0; i < send_string.length; i++){
		console.log ('Итерация: ', i);
		console.log ('Элемент массива при данной итерации: ', arr[i]);
		console.log ('Число ли там? - ', !isNaN(arr[i]));
		if((!isNaN(arr[i]) || (arr[i] == '.')) && (flag == 0)){
			console.log ('Залетели в первый if');
			arr[i] = arr[i].toString();
			var1 += arr[i];
		}
		else if ((arr[i] == '+') && (arr[i+1] == ' ') && (arr[i+2] == '!') && (flag == 0)){
			console.log ('Залетели в плюсовый if');
			flag = 1;
			operator = '!';
			i += 2;
			if (arr[i+1] == '-'){
				console.log ('Залетели в i+3 if');
				operator = '-';
				i++;
			}
		}
		else if (((arr[i] == '-')||(arr[i] == '*')||(arr[i] == '/')) && (flag == 0)){
			console.log ('Залетели во второй if');
			flag = 1;
			operator = arr[i];
		}
		else if ((!isNaN(arr[i]) || (arr[i] == '.')) && (flag == 1)){
			console.log ('Залетели в третий if');
			arr[i] = arr[i].toString();
			var2 += arr[i];
		} else {
			console.log ('Залетели в else. Будет breake');
			break;
		}	
	}
	console.log ('var1: ', var1);
	console.log ('operator: ', operator);
	console.log ('var2: ', var2);
	// -----адрес, куда мы отправим нашу JSON-строку-----
	let url = "https://l8.scripthub.ru/api.php?module=count&var1=" + var1 + "&operator=" + operator + "&var2=" + var2;
	// -----открываем соединение-----
	//console.log (document.form.textview.value);
	//console.log (send_string);
	xhr.open("GET", url, true); 
	xhr.setRequestHeader("Content-Type", "application/json"); 
	//-----обработка обращения к серверу-----
	xhr.onreadystatechange = function () { 
	//-----если запрос принят и сервер ответил, что всё в порядке-----
			if (xhr.readyState === 4 && xhr.status === 200) { 
				send_string = this.responseText;
				send_string = send_string.replace('{"','');
				send_string = send_string.replace('":true}','');
				document.form.textview.value = send_string;
		}	
	}; 
	xhr.send(); 
} 

function result(){
	s++;
	sendJSON();
}

function clean(){
	document.form.textview.value="";
}

function back(){
	var exp =  document.form.textview.value;
	document.form.textview.value = exp.substring(0,exp.length-1);
}

function clean_chislo(){
	var exp =  document.form.textview.value;
	let counter = -1;
	for (let i = 0; i < exp.length; i++){
			if((exp[exp.length - i] != '+') && (exp[exp.length - i] != '-') && (exp[exp.length - i] != '*') && (exp[exp.length - i] != '/'))
				counter++;
			else break;
	}
	document.form.textview.value = exp.substring(0,exp.length-counter);
	if (counter == exp.length-1) document.form.textview.value = "";
}

function znak(){
	var exp =  document.form.textview.value;
	let counter = -1;
	for (let i = 0; i < exp.length; i++){
			if((exp[exp.length - i] != '+') && (exp[exp.length - i] != '-') && (exp[exp.length - i] != '*') && (exp[exp.length - i] != '/'))
				counter++;
			else break;
	}
	var test = exp.substring(0,exp.length-counter)+'-'+exp.substring(exp.length-counter,exp.length);
	document.form.textview.value = test;
	if (counter == exp.length-1) document.form.textview.value = "";
}