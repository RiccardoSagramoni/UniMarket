// Apre la modalita' modifica di un prodotto, attivando il popup con i dati da modificare
function editItem(itemId){
	var popup = document.getElementsByClassName("edit_popup")[0];
	popup.classList.add("show_modal");
	
	var row = document.getElementById("admin-table-item-"+itemId);
	var data = row.getElementsByTagName("td");
	
	formPopup = popup.getElementsByTagName("form")[0];
	formPopup.itemId.value = itemId;
	formPopup.Nome.value = data[1].textContent;
	formPopup.Categoria.value = data[2].textContent;
	formPopup.Descrizione.value = data[3].textContent;
	formPopup.Origine.value = data[4].textContent;
	formPopup.Costo.value = data[5].textContent;
	formPopup.Disponibilita.value = data[7].textContent;
}

// Chiude il popup di modifica del prodotto
function closePopup(){
	var popup = document.getElementsByClassName("edit_popup")[0];
	popup.classList.remove("show_modal");
}

// Validifica il forma per aggiungere un nuovo admin
function validateForm_AddAdmin(form){
	var errorBoxes = document.getElementsByClassName("error_input");
	
	// Nasconde i vecchi messaggi errore
	for(i in errorBoxes){
		errorBoxes[i].style.visibility = "hidden";
	}
	
	// Controlla se le email inserite sono uguali
	if(form.email.value != form.email2.value){
		wrongEmail(form);
		return false;
	}
	else return true;
}

// Modifica graficamente il form per mostrare un errore nella conferma dell'email.
// Usa la funzione errorInput(element) presente sul file signUpForm.js
function wrongEmail(form){
	form.email2.value = '';
	errorInput(form.email2);
	errorInput(form.email);
}