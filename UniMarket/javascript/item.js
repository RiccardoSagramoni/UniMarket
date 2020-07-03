/*	Inserisce gli elementi necessari per la rappresentazione grafica del voto in stelle
 *	-> input: "contenitore del voto in stelle", "voto"
 *	-> return: null
 */
function setStarItem(rateDiv, rate){
	var numberOfFilledStar = Math.floor(rate);
	var numberOfHalfEmptyStar = Math.ceil(rate - numberOfFilledStar);
	var numberOfEmptyStar = 5 - numberOfHalfEmptyStar - numberOfFilledStar;
	
	for(var i = 0; i < numberOfFilledStar; ++i){
		var starItem = document.createElement("img");
		starItem.setAttribute("alt", "filled-star");
		starItem.setAttribute("src", "./../img/star-filled.png");
		starItem.setAttribute("class", "item_star");
		rateDiv.appendChild(starItem);
	}
	for(var i = 0; i < numberOfHalfEmptyStar; ++i){
		var starItem = document.createElement("img");
		starItem.setAttribute("alt", "half-empty-star");
		starItem.setAttribute("src", "./../img/star-half-empty.png");
		starItem.setAttribute("class", "item_star");
		rateDiv.appendChild(starItem);
	}
	for(var i = 0; i < numberOfEmptyStar; ++i){
		var starItem = document.createElement("img");
		starItem.setAttribute("alt", "empty-star");
		starItem.setAttribute("src", "./../img/star-empty.png");
		starItem.setAttribute("class", "item_star");
		rateDiv.appendChild(starItem);
	}
}

/*	Prima di inviare una nuova recensione al server,
 *	controlla che le stelle siano state inserite correttamente
 */
function send(form){
	if(!checkStars(form)){
		errorStars(form);
		return false;
	}
	
	else return true;
}

// Controlla lo stato delle stelle di una recensione
function checkStars(form){
	var value = form.rating.value;
	
	if(value <= 0 || value > 5) return false;
	else return true;
}

// 	Genera un messaggio di errore nel caso in cui le stelle
//	non siano state inserite correttamente all'interno di una recensione
function errorStars(form){
	var doesExist = document.getElementsByClassName("error_box_for_stars")[0];
	if(doesExist != null){
		doesExist.parentNode.removeChild(doesExist);
	}
	
	var box = document.createElement("div");
	box.setAttribute("class", "error_box_for_stars");
	var text = document.createTextNode("Il voto deve essere tra 1 e 5 stelle");
	box.appendChild(text);
	
	form.appendChild(box);
}

// Attiva la modalita' di modifica di una recensione gia' inviata
function modifyMyReview(){
	var recensione = document.getElementById("myReview").getElementsByTagName("textarea")[0];
	recensione.setAttribute("class", "text-recensione");
	recensione.disabled = false;
	
	var button = document.getElementById("modMyReview");
	button.firstChild.nodeValue = "CONFERMA";
	button.setAttribute("onclick", "updateRecensione(document.getElementById('myReview'))");
	button.style.backgroundColor = "limegreen";
	button.style.borderColor = "limegreen";
	
	var button2 = document.getElementById("undoMyMod");
	button2.style.display = "block";
	
	var button3 = document.getElementById("removeMyMod");
	button3.style.display = "block";
	
	var starContainer = document.getElementsByClassName("star-rating disabled")[0];
	starContainer.setAttribute("class","star-rating");
}

//	Controlla i dati della recensione modificata
//	e, nel caso, li invia attraverso metodo GET ad una pagina php
//	per la sottomissione al server
function updateRecensione(recensione){
	var radios = document.getElementsByClassName("star-rating")[0].getElementsByTagName("input");
	var checkedValue = null;
	for(var i = 0; i < radios.length; i++){
		if(radios[i].checked){
			checkedValue = i;
		}
	}
	
	var text = recensione.getElementsByTagName("textarea")[0];
	
	if(checkedValue == null || checkedValue <= 0 || checkedValue > 5) {
		alert("Valore delle stelle non valido");
		return;
	}
	if(text.value.length == 0){
		alert("La descrizione di una recensione non deve essere vuota");
		return;
	}
 
	location.href = "./util/updateReview.php" + location.search + "&s=" + checkedValue + "&t=" + text.value;
}

// 	Invia ad una pagina php i dati necessari per cancellare una recensione
//	(l'utente viene ricavato dai dati di sessione)
function deleteMyReview(){
	location.href = "./util/updateReview.php" + location.search + "&delete=true";
}

//	Dimensiona correttamente l'area testuale di una recensione
function autosizeTextArea(el){
	el.style.height = "auto";
	el.style.height = el.scrollHeight + 'px';
}

// Invia ad una pagina php i dati necessari per cancellare un oggetto dal carrello
function deleteItemTaken(item, howMany){
	location.href = "./util/deleteItemTaken.php?it=" + item + "&hm=" + howMany;
}
