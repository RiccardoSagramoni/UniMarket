// 	OGGETTO EditItemDashboard:
// 	utilizzato per generare e gestire dinamicamente la pagina /php/admin/modifica-prodotto.php,
//	che mostra tutti i prodotti del catalogo, permettendo agli amministratori di modificarne i dati
function EditItemDashboard(){}


// Aggiorna il contenuto della dashboard in seguito ad una modifica dei parametri di ricerca
EditItemDashboard.refreshData =
	function(data){
		EditItemDashboard.removeContent();
		
		EditItemDashboard.addData(data);
	}

// Elimina il contenuto della dashboard
EditItemDashboard.removeContent = 
	function(){
		var dashboardElement = document.getElementById("editItemDashboard");
		if (dashboardElement === null)
			return;
		var firstChild = dashboardElement.firstChild;
		while(firstChild !== null){
			dashboardElement.removeChild(firstChild);
			firstChild = dashboardElement.firstChild;
		}
	
	}

// Inserisce nella dashboard i prodotti cercati
EditItemDashboard.addData =
	function(data){
		var dashboardElement = document.getElementById("editItemDashboard");
		if (dashboardElement === null || data === null || data.length <= 0)
			return;
			
		// Crea i nuovi prodotti cercati
		for (var i = 0; i < data.length; i++){
			var itemElem = EditItemDashboard.createItemElement(data[i]);
			dashboardElement.appendChild(itemElem);
		}		
		
	}
	
// Crea un elemento
EditItemDashboard.createItemElement =
	function(currentData){
		var itemRow = document.createElement("tr");
		itemRow.setAttribute("id", "admin-table-item-" + currentData.itemID);
		itemRow.setAttribute("class", "admin_table_item");
		
		var itemCodice = document.createElement("td");
		itemCodice.textContent = currentData.itemID;
		itemRow.appendChild(itemCodice);
		
		var itemNome = document.createElement("td");
		itemNome.textContent = currentData.nome;
		itemRow.appendChild(itemNome);
		
		var itemCategoria = document.createElement("td");
		itemCategoria.textContent = currentData.categoria;
		itemRow.appendChild(itemCategoria);
		
		var itemDescrizione = document.createElement("td");
		itemDescrizione.textContent = currentData.descrizione;
		itemRow.appendChild(itemDescrizione);
		
		var itemOrigine = document.createElement("td");
		itemOrigine.textContent = currentData.origine;
		itemRow.appendChild(itemOrigine);	
		
		var itemCosto = document.createElement("td");
		itemCosto.textContent = currentData.costo;
		itemRow.appendChild(itemCosto);
		
		var itemRating = document.createElement("td");
		itemRating.textContent = (currentData.rate == 0) ? "-":currentData.rate;
		itemRow.appendChild(itemRating);
		
		var itemQuantita = document.createElement("td");
		itemQuantita.textContent = currentData.disponibilita;
		itemRow.appendChild(itemQuantita);
		
		var itemEdit = document.createElement("td");
		var itemIcona = document.createElement("img");
		itemIcona.setAttribute("class","admin_table_item_icon_edit");
		itemIcona.setAttribute("src","./../../img/edit.png");
		itemIcona.setAttribute("alt","edit");
		itemIcona.setAttribute("onclick","editItem(" + currentData.itemID + ")");
		itemEdit.appendChild(itemIcona);
		itemRow.appendChild(itemEdit);
		
		return itemRow;
	}
	
