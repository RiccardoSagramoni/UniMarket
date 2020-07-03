<?php
	require_once __DIR__ . '.\..\..\config.php';
	require_once DIR_BASE . '/php/util/uniMarketDbManager.php';
	
	//
	// SEZIONE UTENTE
	//
	
	// Inserisce un nuovo utente nel database e restituisce sia l'esito dell'operazione che l'eventuale errore generato
	function insertNewUser($nome, $cognome, $email, $password, $datanascita, $sesso, $telefono, $indirizzo, $citta, $cap){
		global $uniMarketDb;
		
		$nome = $uniMarketDb->sqlInjectionFilter($nome);
		$cognome = $uniMarketDb->sqlInjectionFilter($cognome);
		$email = $uniMarketDb->sqlInjectionFilter($email);
		$password = $uniMarketDb->sqlInjectionFilter($password);
		$datanascita = $uniMarketDb->sqlInjectionFilter($datanascita);
		$sesso = $uniMarketDb->sqlInjectionFilter($sesso);
		$telefono = $uniMarketDb->sqlInjectionFilter($telefono);
		$indirizzo = $uniMarketDb->sqlInjectionFilter($indirizzo);
		$citta = $uniMarketDb->sqlInjectionFilter($citta);
		$cap = $uniMarketDb->sqlInjectionFilter($cap);
		
		$query = "INSERT INTO user VALUES
				(NULL, '".$email."', '".$password."', '".$nome."', '".$cognome."', '".$datanascita."', '"
				.$sesso."', '".$telefono."', '".$indirizzo."', '".$citta."', '".$cap."', 0);";
		
		$result = $uniMarketDb->performQuery($query);
		$errorNumber = $uniMarketDb->getErrorNumber();
		$errorText = $uniMarketDb->getErrorText();
		$returnArray = array( "result"=>$result, "errorNumber"=>$errorNumber, "errorText"=>$errorText);
		$uniMarketDb->closeConnection();
		return $returnArray;
	}
	
	// Preleva il codice identificativo di un utente, data l'email
	function getUserId($email){
		global $uniMarketDb;
		
		$email = $uniMarketDb->sqlInjectionFilter($email);
		
		$query = "SELECT userId FROM user WHERE email = '".$email."';";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		$result = $result->fetch_assoc();
		return $result["userId"];
	}
	
	// Preleva i dati di un utente
	function getDataUser($userId){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		
		$query = "SELECT * FROM user WHERE userID = '".$userId."';";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Controlla se la password inserita e' corretta
	function checkPassword($userId,$password,$admin = null){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$password = $uniMarketDb->sqlInjectionFilter($password);
		
		$query = "SELECT * FROM user WHERE userId = '".$userId."' AND password = '".$password."'";
		
		if(isset($admin) && $admin!=null && $admin==true){
			$query = $query . " AND isAdmin = 1";
		}
		
		$query = $query . ";";
		
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Imposta un dato utente come amministratore
	function setUserAsAdmin($email){
		global $uniMarketDb;
		
		$email = $uniMarketDb->sqlInjectionFilter($email);
		
		$query = "UPDATE user SET isAdmin = 1 WHERE email = '".$email."';";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Cambia l'email di un utente
	function changeEmailUser($userId, $email){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$email = $uniMarketDb->sqlInjectionFilter($email);
		
		$query = "UPDATE user SET email = '".$email."' WHERE userID = '".$userId."';";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Cambia la password di un utente
	function changePasswordUser($userId,$password){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$password = $uniMarketDb->sqlInjectionFilter($password);
		
		$query = "UPDATE user SET password = '".$password."' WHERE userID = '".$userId."';";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Cambia il numero di telefono di un utente
	function changePhoneNumberUser($userId,$telefono){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$telefono = $uniMarketDb->sqlInjectionFilter($telefono);
		
		$query = "UPDATE user SET telefono = '".$telefono."' WHERE userID = '".$userId."';";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Cambia l'indirizzo di un utente
	function changeAddressUser($userId,$indirizzo,$citta,$cap){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$indirizzo = $uniMarketDb->sqlInjectionFilter($indirizzo);
		$citta = $uniMarketDb->sqlInjectionFilter($citta);
		$cap = $uniMarketDb->sqlInjectionFilter($cap);
		
		$query = "UPDATE user SET indirizzo = '".$indirizzo."', citta = '".$citta."', cap = '".$cap."' WHERE userID = '".$userId."';";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	
	//
	// Sezione ITEMS
	//
	
	// Cerca i prodotti all'interno di una categoria di oggetti, 
	// che combaciano ad un dato pattern (se specificato)
	function searchItemsByCategory($offset, $itemsToLoad, $category, $pattern = null){
		global $uniMarketDb;
		
		$category = $uniMarketDb->sqlInjectionFilter($category);
		$offset = $uniMarketDb->sqlInjectionFilter($offset);
		$itemsToLoad = $uniMarketDb->sqlInjectionFilter($itemsToLoad);
		
		$query = "SELECT *, itemsRate(itemID) AS rate
					FROM item
					WHERE Categoria = '".$category."'";
		
		if($pattern !== null){
			$pattern = $uniMarketDb->sqlInjectionFilter($pattern);
			$query = $query . " AND Nome LIKE '%" . $pattern . "%'";
		}
		$query = $query." ORDER BY Disponibilita DESC LIMIT ".$offset.", ".$itemsToLoad.";";
		
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Restituisce i dati utili di un prodotto
	function getItemById($itemId){
		global $uniMarketDb;
		
		$itemId = $uniMarketDb->sqlInjectionFilter($itemId);
		
		$query = "SELECT *, itemsRate(itemID) AS rate FROM item WHERE itemID = '".$itemId."';";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		$row = $result->fetch_assoc();
		return $row;
	}
	
	// Restituisce tutti i dati dei prodotti che rispettano un dato pattern
	function showItems($itemsToLoad,$offset,$pattern){
		global $uniMarketDb;
		
		$pattern = $uniMarketDb->sqlInjectionFilter($pattern);
		
		$query = "	SELECT *, itemsRate(itemID) AS rate
					FROM item
					WHERE Nome LIKE '%" . $pattern . "%'
					LIMIT ".$offset.", ".$itemsToLoad.";";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Controlla la disponibilta di un prodotto
	// RETURN-> Quantita' rimasta disponibile
	function checkItemAvailable($itemID){
		global $uniMarketDb;
		
		$itemID = $uniMarketDb->sqlInjectionFilter($itemID);
		
		$query = "SELECT disponibilita FROM item WHERE itemID = ".$itemID.";";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		$row = $result->fetch_assoc();
		return $row["disponibilita"];
	}
	
	// Aggiunge un nuovo prodotto nel catalogo
	function insertItem($nome, $categoria, $descrizione, $origine, $costo, $disponibilita){
		global $uniMarketDb;
		
		$nome = $uniMarketDb->sqlInjectionFilter($nome);
		$categoria = $uniMarketDb->sqlInjectionFilter($categoria);
		$descrizione = $uniMarketDb->sqlInjectionFilter($descrizione);
		$origine = $uniMarketDb->sqlInjectionFilter($origine);
		$costo = $uniMarketDb->sqlInjectionFilter($costo);
		$disponibilita = $uniMarketDb->sqlInjectionFilter($disponibilita);
		
		$query = "INSERT INTO item VALUES (NULL, '".$nome."', '".$categoria."', '".$descrizione."',
					'".$origine."',".$costo.",".$disponibilita.");";
		
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		return $result;
	}
	
	// Aggiorna i dati relativi ad un prodotto
	function updateItemData($itemId, $nome, $categoria, $descrizione, $origine, $costo, $disponibilita){
		global $uniMarketDb;
		
		$itemId = $uniMarketDb->sqlInjectionFilter($itemId);
		$nome = $uniMarketDb->sqlInjectionFilter($nome);
		$categoria = $uniMarketDb->sqlInjectionFilter($categoria);
		$descrizione = $uniMarketDb->sqlInjectionFilter($descrizione);
		$origine = $uniMarketDb->sqlInjectionFilter($origine);
		$costo = $uniMarketDb->sqlInjectionFilter($costo);
		$disponibilita = $uniMarketDb->sqlInjectionFilter($disponibilita);
		
		$query = "UPDATE item SET nome = '".$nome."', categoria = '".$categoria."', descrizione = '".$descrizione."',
					origine = '".$origine."', costo = ".$costo.", disponibilita = ".$disponibilita."
					WHERE itemId = ".$itemId.";";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		return $result;
	}
	
	// Aggiunge un prodotto all'attuale carrello
	function addItemTaken($itemID, $userID, $howMany = 1){
		global $uniMarketDb;
		
		$userID = $uniMarketDb->sqlInjectionFilter($userID);
		$itemID = $uniMarketDb->sqlInjectionFilter($itemID);
		$howMany = $uniMarketDb->sqlInjectionFilter($howMany);
		
		$carrello = getCurrentShoppingCart($userID);
		
		if(isItemAlreadyInShoppingCart($itemID, $carrello)){
			$query = "	UPDATE itemtaken
						SET howMany = howMany + ".$howMany."
						WHERE shoppingId = ".$carrello."
							AND itemId = ".$itemID.";";
		}
		else{
			$query = "INSERT INTO itemtaken VALUES (".$carrello.", ".$itemID.", ".$howMany.");";
		}

		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		return countItemTaken($carrello);
	}
	
	// Rimuove un prodotto dall'attuale carrello
	function removeItemTaken($userId, $itemId, $howMany = 1){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$itemId = $uniMarketDb->sqlInjectionFilter($itemId);
		$howMany = $uniMarketDb->sqlInjectionFilter($howMany);
		
		$carrello = getCurrentShoppingCart($userId);
		
		$query1 = "SELECT howMany FROM itemtaken WHERE itemId = ".$itemId." AND shoppingId = ".$carrello.";";
		$result1 = $uniMarketDb->performQuery($query1);
		$row1 = $result1->fetch_assoc();
		$howManyItems = $row1["howMany"];
		
		if($howManyItems == null) return;
		
		if ($howManyItems > $howMany){
			$query = "UPDATE itemtaken SET howMany = howMany - ".$howMany." WHERE shoppingId = ".$carrello." AND itemId = ".$itemId.";";
		}
		else{
			$query = "DELETE FROM itemtaken WHERE shoppingId = ".$carrello." AND itemId = ".$itemId.";";
		}
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		return $result;
	}

	
	
	//
	// Sezione CARRELLO (Shopping Cart)
	//
	
	// Preleva il codice del carrello attualmente aperto dell'utente
	// Ne apre uno se il risultato e' vuoto
	function getCurrentShoppingCart($userID){
		global $uniMarketDb;
		
		$query = "SELECT shoppingID FROM shoppingcart WHERE userID = ".$userID." AND TimestampChiusura IS NULL;";
		
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		$row = $result->fetch_assoc();
		
		if ($row["shoppingID"] == null){
			return openNewShoppingCart($userID);
		}
		return $row["shoppingID"];
	}
	
	// Apre un nuovo carrello
	// RETURN-> ID del nuovo carrello aperto
	function openNewShoppingCart($userID){
		global $uniMarketDb;
		
		$query = "INSERT INTO shoppingcart VALUES (NULL, ".$userID.", CURRENT_TIMESTAMP, NULL,NULL,NULL,NULL,NULL);";
		$uniMarketDb->performQuery($query);
		
		$queryForId = "SELECT shoppingID FROM shoppingcart WHERE userID = ".$userID." AND TimestampChiusura IS NULL;";
		
		$resultID = $uniMarketDb->performQuery($queryForId);
		$uniMarketDb->closeConnection();
		
		$row = $resultID->fetch_assoc();
		
		return $row["shoppingID"];
	}
	
	// Controlla che un dato prodotto sia gia' stato inserito in un dato carrello
	// RETURN-> true/false
	function isItemAlreadyInShoppingCart($itemId, $carrello){
		global $uniMarketDb;
		
		$query = "SELECT * FROM itemtaken WHERE itemId = ".$itemId." AND shoppingId = ".$carrello.";";
		
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		$row = $result->fetch_assoc();
		
		return ($row != null);
	}
	
	// Conta gli oggetti in un carrello
	function countItemTaken($carrello){
		global $uniMarketDb;
		
		$query = "SELECT SUM(i.howMany) AS howMany FROM itemtaken i WHERE i.shoppingID = ".$carrello.";";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Restituisce tutti i prodotti di un dato carello
	function getAllItemsOfShoppingCart($shoppingID){
		global $uniMarketDb;
		
		$shoppingID = $uniMarketDb->sqlInjectionFilter($shoppingID);
		
		$query = "	SELECT 	i.itemId,
							i.Nome,
							i.Categoria,
							i.Costo,
							t.howMany
					FROM itemtaken t
						NATURAL JOIN
						item i
					WHERE shoppingID = ".$shoppingID."
					ORDER BY i.categoria, i.nome;";
		
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		return $result;
	}
	
	// Chiude il carrello e lo sottomette al sistema
	function sottomettiCarrello($shoppingId){
		global $uniMarketDb;
		
		$shoppingId = $uniMarketDb->sqlInjectionFilter($shoppingId);
		
		$query = "	UPDATE shoppingcart
					SET TimestampChiusura = CURRENT_TIMESTAMP
					WHERE shoppingID = ".$shoppingId.";";
		
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Ottiene i dati di tutti i carrelli chiusi (ovvero gli ordini inviati) di un dato utente
	function getAllClosedShoppingCart($userId){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		
		$query = "SELECT * FROM shoppingcart WHERE userId = ".$userId." AND TimestampChiusura IS NOT NULL ORDER BY shoppingId DESC;";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		return $result;
	}
	
	// Restituisce l'utente proprietario di un dato ordine inviato
	function getUserOfClosedShoppingCart($shoppingId){
		global $uniMarketDb;
		
		$shoppingId = $uniMarketDb->sqlInjectionFilter($shoppingId);
		
		$query = "SELECT userId FROM shoppingCart WHERE shoppingId = ".$shoppingId." AND TimestampChiusura IS NOT NULL";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		$row = $result->fetch_assoc();
		
		return $row["userId"];
	}
	
	// Ottiene le attuali spese fisse di spedizione
	function getSpeseSpedizione(){
		global $uniMarketDb;
		
		$query = "SELECT Valore FROM Costanti WHERE id = 1;";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		$row = $result->fetch_assoc();
		
		return $row["Valore"];
	}
	
	
	//
	// Sezione RECENSIONE
	//
	
	// Inserisce una recensione
	function insertRecensione($userId, $itemId, $rating, $testo){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$itemId = $uniMarketDb->sqlInjectionFilter($itemId);
		$rating = $uniMarketDb->sqlInjectionFilter($rating);
		$testo = $uniMarketDb->sqlInjectionFilter($testo);
		
		$query = "INSERT INTO recensione VALUES(".$userId.", ".$itemId.", CURRENT_TIMESTAMP, ".$rating.", '".$testo."');";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Controlla se l'utente ha gia' recensito l'oggetto visualizzato.
	// Nel caso, restituisce i dati della recensione (altrimenti restituisce NULL)
	function checkIfAlreadyRated($userId, $itemId){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$itemId = $uniMarketDb->sqlInjectionFilter($itemId);
		
		$query = "SELECT 	r.*,
							u.Nome AS NomeUtente, 
							u.Cognome AS CognomeUtente
					FROM recensione r
						INNER JOIN
						user u ON (u.userID = r.Autore)
					WHERE r.ProdottoRecensito = ".$itemId."
						AND u.userId =".$userId.";";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Preleva tutti i dati delle recensioni di un prodotto
	function getAllReviewsAndData($itemId){
		global $uniMarketDb;
		
		$itemId = $uniMarketDb->sqlInjectionFilter($itemId);
		
		$query = "	SELECT 	r.*,
							u.userId AS userId,
							u.Nome AS NomeUtente, 
							u.Cognome AS CognomeUtente
					FROM recensione r
						INNER JOIN
						user u ON (u.userID = r.Autore)
					WHERE r.ProdottoRecensito = ".$itemId.";";
		
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}
	
	// Sovrascrive una recensione
	function replaceRecensione($userId, $itemId, $rating, $testo){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$itemId = $uniMarketDb->sqlInjectionFilter($itemId);
		$rating = $uniMarketDb->sqlInjectionFilter($rating);
		$testo = $uniMarketDb->sqlInjectionFilter($testo);
		
		$query = "REPLACE INTO recensione VALUES(".$userId.", ".$itemId.", CURRENT_TIMESTAMP, ".$rating.", '".$testo."');";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		return $result;
	}

	// Cancella una recensione	
	function deleteRecensione($userId, $itemId){
		global $uniMarketDb;
		
		$userId = $uniMarketDb->sqlInjectionFilter($userId);
		$itemId = $uniMarketDb->sqlInjectionFilter($itemId);
		
		$query = "DELETE FROM recensione WHERE Autore = ".$userId." AND ProdottoRecensito = ".$itemId.";";
		$result = $uniMarketDb->performQuery($query);
		$uniMarketDb->closeConnection();
		
		return $result;
	}
	
?>