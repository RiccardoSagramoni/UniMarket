<?php
	// FILE per la gestione server dei carrelli
	session_start();
	
	require_once __DIR__ ."./../../config.php";
	require_once DIR_BASE . "/php/util/databaseFunctionManagement.php";
	require_once DIR_BASE . "/php/ajax/AjaxResponse.php";
	
	$response = new AjaxResponse();
	
	// Carica nell'attuale carrello i prodotti inseriti nel carrello con codice $_GET["shoppingID"]
	if(isset($_GET["shoppingID"])){
		$shoppingID = $_GET["shoppingID"];
		$proprietario = getUserOfClosedShoppingCart($shoppingID);
		
		// Controlla che il proprietario del carrello da copiare sia lo l'utente loggato (per motivi di privacy)
		if($proprietario == null || $proprietario != $_SESSION['uniMarketuserId']){
			echo json_encode($response);
			return;
		}
		
		$result = getAllItemsOfShoppingCart($shoppingID);
		
		if($result == null){
			echo json_encode($response);
			return;
		}
		
		while($row = $result->fetch_assoc()){
			addItemTaken($row["itemId"],$_SESSION['uniMarketuserId'],$row["howMany"]);
		}
		
		$message = "OK";	
		$response = setResponse($result, $message);
		echo json_encode($response);
		return;
	}
	
	if(!isset($_GET["itemID"]) || !isset($_GET["howMany"])){
		echo json_encode($response);
		return;
	}
	
	// Carica un prodotto nel carrello attuale
	$itemID = $_GET["itemID"];
	$howMany = $_GET["howMany"];
	
	$disponibilita = checkItemAvailable($itemID);
	
	if($disponibilita < $howMany){
		$warningResponse = new AjaxResponse("-1", "notEnoughItems");
		$warningResponse->data[0] = $disponibilita;
		echo json_encode($warningResponse);
		return;
	}
	
	$result = addItemTaken($itemID, $_SESSION["uniMarketuserId"], $howMany);
	
	
	if (checkEmptyResult($result)){
		$response = setEmptyResponse();
		echo json_encode($response);
		return;
	}
	
	$message = "OK";	
	$response = setResponse($result, $message);
	echo json_encode($response);
	return;
	
	
	function checkEmptyResult($result){
		if ($result === null || !$result)
			return true;
			
		return ($result->num_rows <= 0);
	}
	
	function setEmptyResponse(){
		$message = "error: emptyResponse";
		return new AjaxResponse("-1", $message);
	}
	
	function setResponse($result, $message){
		$response = new AjaxResponse("0", $message);
		
		$row = $result->fetch_assoc();
		
		if($result->num_rows == 1){
			$response->data[0] = $row["howMany"];
		}
		
		return $response;
	}
?>