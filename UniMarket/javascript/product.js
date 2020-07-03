//	Lancia la funziona selectMoreItems se l'utente ha selezionato
//	l'opzione "..." come quantita' di un'oggetto dello store
function selectionChangeHandler(mainItemID, value){
	if (value == 0){
		var mainItem = document.getElementById(mainItemID);
		selectMoreItems(mainItem);
	}
}

// 	Attiva la modalita' necessaria per inserire nel carrello
//	piu' di 5 istanze di uno stesso oggetto
function selectMoreItems(item){
	var input = item.getElementsByClassName("item_description")[0].getElementsByClassName("item_amount")[0].getElementsByClassName("elem");
	input[0].style.display = "none";
	input[1].style.display = "block";
	input[1].focus();
}