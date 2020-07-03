// 	OGGETTO ItemDashboard:
// 	utilizzato per generare e gestire dinamicamente la pagina /php/product.php,
//	che mostra i prodotti relativi ad una data categoria all'interno di una "dashboard"
function ItemDashboard(){}

ItemDashboard.DEFAULT_ITEM_IMG = "./../img/ImageNotAvailable.png";

// Elimina il contenuto della dashboard
ItemDashboard.removeContent = 
	function(){
		var dashboardElement = document.getElementById("itemDashboard");
		if (dashboardElement === null)
			return;
		var firstChild = dashboardElement.firstChild;
		while(firstChild !== null){
			dashboardElement.removeChild(firstChild);
			firstChild = dashboardElement.firstChild;
		}
	
	}

// Mostra una dashboard vuota con annesso messaggio di warning (non ci sono ulteriori prodotti)
ItemDashboard.setEmptyDashboard = 
	function(){
		ItemDashboard.removeContent();
		var warningDivElem = document.createElement("div");
		warningDivElem.setAttribute("class", "warning");
		var warningSpanElem = document.createElement("span");
		warningSpanElem.textContent = "Non ci sono ulteriori prodotti!";
		
		warningDivElem.appendChild(warningSpanElem);
		
		var dashboardElement = document.getElementById("itemDashboard");
		dashboardElement.appendChild(warningDivElem);
		
	}

// Inserisce nella dashboard i prodotti cercati
ItemDashboard.addData =
	function(data){
		var dashboardElement = document.getElementById("itemDashboard");
		if (dashboardElement === null || data === null || data.length <= 0)
			return;
			
		// Crea i nuovi prodotti cercati
		for (var i = 0; i < data.length; i++){
			var itemElem = ItemDashboard.createItemElement(data[i]);
			dashboardElement.appendChild(itemElem);
		}		
		
	}

// Aggiorna il contenuto della dashboard in seguito ad una modifica dei parametri di ricerca
ItemDashboard.refreshData =
	function(data){
		ItemDashboard.removeContent();
		
		ItemDashboard.addData(data);
	}

// Crea graficamente il prodotto da visualizzare nella dashboard
ItemDashboard.createItemElement = 	
	function(currentData){
		var itemDiv = document.createElement("div");
		itemDiv.setAttribute("id", "item-" + currentData.itemID);
		itemDiv.setAttribute("class", "item");
		
		itemDiv.appendChild(ItemDashboard.createImageElement(currentData));
		itemDiv.appendChild(ItemDashboard.createDescription(currentData));
		
		if(currentData.disponibilita <= 0){
			itemDiv.appendChild(ItemDashboard.createSoldOutElement(currentData));
			itemDiv.setAttribute("class", "item sold_out");
		}
		
		return itemDiv;
	}

// Crea l'immagine del prodotto da visualizzare nella dashboard
ItemDashboard.createImageElement = 
	function(currentData){
		var linkA = document.createElement("a");
		linkA.setAttribute("class", "item_img_link");
		linkA.setAttribute("href", "./item.php?id=" + currentData.itemID);
		
		var img = document.createElement("img");
		img.setAttribute("alt", "item" + currentData.itemID);
		img.setAttribute("src", "./../img/items/item-" + currentData.itemID + ".jpg");
		img.setAttribute("onerror", "ItemDashboard.onErrorImage(this)")
		
		linkA.appendChild(img);
		return linkA;
	}

// Inserisce come immagine di un prodotto il poster "No photo available"
// nel caso in cui il browser non riesca a trovare l'immagine originale nel server
// (ad esempio nel caso in cui non esista
ItemDashboard.onErrorImage =
	function(img){
		img.setAttribute("src", ItemDashboard.DEFAULT_ITEM_IMG);
	};

// Crea graficamente la descrizione di un prodotto (titolo + prezzo + rating + ...)
ItemDashboard.createDescription = 
	function(currentData){
		var mainDiv = document.createElement("div");
		mainDiv.setAttribute("class", "item_description");
		
		// Inserisce il titolo
		var titleLink = document.createElement("a");
		titleLink.setAttribute("href","./item.php?id=" + currentData.itemID);
		titleDiv = document.createElement("div");
		titleDiv.setAttribute("class", "item_title");
		titleDiv.textContent = currentData.nome;
		
		titleLink.appendChild(titleDiv);
		mainDiv.appendChild(titleLink);
		
		// Inserisce il prezzo
		var prezzoDiv = document.createElement("div");
		prezzoDiv.setAttribute("class", "item_prezzo");
		prezzoDiv.textContent = "€ " + currentData.costo;
		mainDiv.appendChild(prezzoDiv);
		
		// Inserisce il voto in stelle
		var rateDiv = document.createElement("div");
		rateDiv.setAttribute("class", "item_voto");
		
		var numberOfFilledStar = Math.floor(currentData.rate);
		var numberOfHalfEmptyStar = Math.ceil(currentData.rate - numberOfFilledStar);
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
		
		mainDiv.appendChild(rateDiv);
		
		// Inserisce il pulsante per la quantità
		var amountDiv = document.createElement("div");
		amountDiv.setAttribute("class", "item_amount");
		
		var amountSelect = document.createElement("select");
		amountSelect.setAttribute("class", "elem");
		amountSelect.setAttribute("onchange", "selectionChangeHandler('item-" + currentData.itemID + "', this.value)");
		
		var numberOfOptions = 6;
		for (var i = 1; i <= numberOfOptions; ++i){
			var amountOption = document.createElement("option");
			amountOption.setAttribute("value", i%numberOfOptions);
			
			if(i === 1)
				amountOption.setAttribute("selected", "selected");
			
			var optionText;
			if(i < numberOfOptions)
				optionText = document.createTextNode(i);
			else
				optionText = document.createTextNode("...");
			
			amountOption.appendChild(optionText);
			amountSelect.appendChild(amountOption);
		}
		
		var amountInput = document.createElement("input");
		amountInput.setAttribute("class", "elem");
		amountInput.setAttribute("type", "number");
		amountInput.setAttribute("step", "1");
		amountInput.setAttribute("min", "1");
		amountInput.setAttribute("max", "99");
		amountInput.setAttribute("value", "");
		amountInput.style.display = "none";
		
		amountDiv.appendChild(amountSelect);
		amountDiv.appendChild(amountInput);
		mainDiv.appendChild(amountDiv);
		
		// Inserisce il pulsante carrello
		var carrelloDiv = document.createElement("button");
		carrelloDiv.setAttribute("class", "item_carrello");
		carrelloDiv.addEventListener("click", function(){
					ShoppingCart.addItemToShoppingCart(currentData.itemID)
		});
		
		mainDiv.appendChild(carrelloDiv);
		
		return mainDiv;
	}

// Modifica graficamente un prodotto non piu' disponibile nel magazzino
// in modo che non possa essere aggiunto al carrello
ItemDashboard.createSoldOutElement =
	function(currentData){
		var img = document.createElement("img");
		img.setAttribute("class", "sold_out_img");
		img.setAttribute("src", "./../img/sold-out.png");
		img.setAttribute("alt", "SOLD OUT");
		return img;
	}
	
// Gestisce graficamente le frecce per la navigazione tra le pagine
ItemDashboard.updateNavigationPage = 
	function(currentPage, noMoreDataExist){
		// Update the number of the page
		var currentPageElems = document.getElementsByClassName("currentPage");
		for (var i = 0; i < currentPageElems.length; i++)
			currentPageElems[i].textContent = "Pagina " + currentPage;
		
		var previousElems = document.getElementsByClassName("previous");
		for (var i = 0; i < previousElems.length; i++){
			if (currentPage === 1) // Disable the previous event
				previousElems[i].disabled = true;
			else // Enable the previous event
				previousElems[i].disabled = false;
			
		}
		
		var nextElems = document.getElementsByClassName("next");
		for (var i = 0; i < nextElems.length; i++){
			if (noMoreDataExist) // Disable the next event
				nextElems[i].disabled = true;
			else // Enable the previous event
				nextElems[i].disabled = false;
			
		}
	}
	
// Mostra un messaggio che confermi all'utente la corretta aggiunta dell'oggetto selezionato al proprio careelo	
ItemDashboard.showAlertBoxForAddItemToShoppingCart =
	function(){
		var message = "Il prodotto selezionato è stato correttamente aggiunto al carrello";
		var classBox = "popup_box_for_item_taken alert_box_for_item_taken";
		
		ItemDashboard.createPopupBox(message, classBox);
	}

// Mostra un messaggio di errore nel caso in cui un prodotto selezionato dall'utente sia esaurito
ItemDashboard.errorBoxForNotEnoughItems =
	function(disponibilita) {
		if(disponibilita > 0)
			var message = "Sono rimasti solo " + disponibilita + " prodotti selezionati. Prego selezionarne un numero minore";
		else
			var message = "Il prodotto è esaurito";
		
		var classBox = "popup_box_for_item_taken error_box_for_item_taken";
		
		ItemDashboard.createPopupBox(message, classBox);
	}

// Crea un messaggio sullo schermo
ItemDashboard.createPopupBox =
	function(message, classBox){
		var box = document.createElement("div");
		var boxText = document.createTextNode(message);
		box.appendChild(boxText);
		
		box.setAttribute("class", classBox);
		
		var body = document.getElementsByTagName('body')[0];
		body.appendChild(box);
		
		// Genera effetto di fadeIn
		ItemDashboard.fadeIn(box);
		// Setta Timer per fadeOut
		var timer = setTimeout(function() {
				ItemDashboard.fadeOut(box);
			}, 4000);
	}

// Genera un effetto di dissolvenza in entrata di un dato elemento (e.g. popup box)
ItemDashboard.fadeIn =
	function (element){
		var op = 0.1; // initial opacity
		
		var timer = setInterval(function () {
			if (op >= 1){
				clearInterval(timer);
				op = 1;
			}
			
			element.style.opacity = op;
			op += op * 0.1;
		}, 20);
    }

// Genera un effetto di dissolvenza in uscita di un dato elemento (e.g. popup box)
ItemDashboard.fadeOut =
	function (element){
		var op = element.style.opacity;  // initial opacity
		
		var timer = setInterval(function () {
			if (op <= 0.001){
				clearInterval(timer);
				element.parentNode.removeChild(element);
			}
			else{
				element.style.opacity = op;
				op -= op * 0.05;
			}
		}, 20);
    }