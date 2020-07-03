// OGGETTO ShoppingCart:
// utilizzato per gestire dinamicamente la connessione AJAX con il server
// relativamente all'aggiornamento del carrello (Shopping Cart)
function ShoppingCart(){}

ShoppingCart.DEFAUL_METHOD = "GET";
ShoppingCart.URL_REQUEST = "./ajax/shoppingCart.php";
ShoppingCart.URL_REQUEST_SC_TO_SC = "./../ajax/shoppingCart.php";
ShoppingCart.ASYNC_TYPE = true;

ShoppingCart.SUCCESS_RESPONSE = "0";
ShoppingCart.WARNING_CODE = "-1";
ShoppingCart.NOT_ENOUGH_ITEMS = "notEnoughItems";

ShoppingCart.addItemToShoppingCart = 
	function (itemID, howMany = null, isThisItemPage = null){
		if(howMany == null){
			howMany = ShoppingCart.howManyItemsToAdd(itemID);
		}
		
		if (howMany < 0) return;
		
		ShoppingCart.setCursorLoading(1);
		
		var queryString = "?itemID=" + itemID + "&howMany=" + howMany;
		
		var url = ShoppingCart.URL_REQUEST + queryString;
		var responseFunction = ShoppingCart.onAjaxResponse;
	
		AjaxManager.performAjaxRequest(ShoppingCart.DEFAUL_METHOD, 
										url, ShoppingCart.ASYNC_TYPE, 
										null, responseFunction);
	}
	
ShoppingCart.copyShoppingCartIntoShoppingCart = 
	function (shoppingID){
		
		var queryString = "?shoppingID=" + shoppingID;
		
		ShoppingCart.setCursorLoading(1);
		
		var url = ShoppingCart.URL_REQUEST_SC_TO_SC + queryString;
		var responseFunction = ShoppingCart.onAjaxResponseForShoppingCart;
	
		AjaxManager.performAjaxRequest(ShoppingCart.DEFAUL_METHOD, 
										url, ShoppingCart.ASYNC_TYPE, 
										null, responseFunction);
	}

ShoppingCart.howManyItemsToAdd =
	function(itemID){
		var thisItem = document.getElementById("item-"+itemID);
		if(thisItem === null) return -1;
		
		var elem = thisItem.getElementsByClassName("item_description")[0].getElementsByClassName("item_amount")[0].getElementsByClassName("elem");
		
		if(elem[1].style.display == 'none' && elem[0].validity.valid){
			return elem[0].value;
		}
		else if(elem[0].style.display == 'none' && elem[1].validity.valid){
			return elem[1].value;
		}
		else return -1;
	}

ShoppingCart.onAjaxResponse = 
	function(response){
		ShoppingCart.setCursorLoading(0);
		if (response.responseCode === ShoppingCart.WARNING_CODE
			&& response.message === ShoppingCart.NOT_ENOUGH_ITEMS){
				ItemDashboard.errorBoxForNotEnoughItems(response.data[0]);
				return;
		}
		
		if (response.responseCode === ShoppingCart.SUCCESS_RESPONSE){
			ShoppingCart.refreshData(response.data);
			ItemDashboard.showAlertBoxForAddItemToShoppingCart();
		}
	}
	
ShoppingCart.onAjaxResponseForShoppingCart =
	function(response){
		ShoppingCart.setCursorLoading(0);
		if (response.responseCode === ShoppingCart.WARNING_CODE){
			alert("Qualcosa e' andato storto. Riprovate piu' tardi.");
			return;
		}
		
		if (response.responseCode === ShoppingCart.SUCCESS_RESPONSE){
			location.href = "./../carrello.php";
		}
	}

// Disattiva il cursore e i pulsanti "aggiungi al carrello" mentre aspetta una risposta del server
// e li riattiva una volta giunta la risposta.
// In questo modo si evita che l'utente, non vedendo comparire il messaggio di risposta sullo schermo,
// compra erroneamente due volte il medesimo prodotto
ShoppingCart.setCursorLoading =
	function(state){
		var cursorBody = (state == 1) ? "wait" : "";
		var cursorBotton = (state == 1) ? "wait" : "";
		var disableButton = (state == 1) ? "disabled" : "";
		document.getElementsByTagName("body")[0].style.cursor = cursorBody;
		
		var buttons = document.getElementsByTagName("button");
			for(var i = 0; i < buttons.length; i++){
				buttons[i].style.cursor = cursorBotton;
				buttons[i].disabled = disableButton;
			}
	}
	
ShoppingCart.refreshData =
	function(currentData){
		var numberOfShoppingCart = document.getElementById("numero_carrello");
		numberOfShoppingCart.firstChild.nodeValue = currentData[0];
	}
	