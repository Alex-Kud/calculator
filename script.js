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

function result(){
	s++;
	var res = document.form.textview.value;
			$.ajax({
            type: "GET",
            url: '/api.php',
			cahe: false,
            dataType: "json",
            data: 'param='+JSON.stringify(res),
			/*success: function(data) {
				document.form.textview.value = data;
			}*/
			success:function(data){
				console.log(data);
			},
			error:function(data){
				console.log('error');
				console.log(data);
			}
		})	 
	//if(res) document.form.textview.value = eval(res);
}

function clean(){
	document.form.textview.value="";
	//s = 0;
	//s2 = 0;
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