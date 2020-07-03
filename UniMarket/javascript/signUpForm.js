/*	Questo file contiene le funzioni necessarie per controllare la correttezza e la consistenza
 *	dei dati inseriti dall'utente in fase di registrazione
*/

function validateForm(form){
	if(form.password.value != form.confermaPassword.value){
		wrongPassword(form);
		return false;
	}
	return true;
}

function wrongPassword(form){
	form.confermaPassword.value = '';
	errorInput(form.confermaPassword);
	errorInput(form.password);
}

function errorInput(elem){
	elem.style.borderColor = 'red';
	elem.style.boxShadow = '0px 0px 10px red';
	var error = elem.parentNode.getElementsByClassName("input_error")[0];
	if (error){
		error.style.visibility = 'visible';
	}
}

function checkIf18Years(nascita){
	if((Date.now() - Date.parse(nascita)) < (18*365*24*3600*1000)) return false;
	else return true;
}

function errorDate(date){
	if(!checkIf18Years(date.value)){
		date.setCustomValidity("Devi essere maggiorenne per poter usufruire di questo servizio");
	}
	else{
		date.setCustomValidity("");
	}
}
