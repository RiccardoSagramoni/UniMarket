<?php
	// FILE per caricare i dati dei prodotti nella pagina /php/product.php
	session_start();
	
	require_once __DIR__ ."./../../config.php";
	require_once DIR_BASE . "/php/util/databaseFunctionManagement.php";
	require_once DIR_BASE . "/php/ajax/AjaxResponse.php";
	
	$response = new AjaxResponse();
	
	if (!isset($_GET['categoryToSearch']) || !isset($_GET['itemsToLoad']) || !isset($_GET['offset'])){
		echo json_encode($response);
		return;
	}
	
	$categoryToSearch = $_GET['categoryToSearch'];
	$itemsToLoad = $_GET['itemsToLoad'];
	$offset = $_GET['offset'];
	
	$pattern = null;
	if (isset($_GET['pattern'])){
		$pattern = $_GET['pattern'];
	}
	
	$result = searchItemsByCategory($offset, $itemsToLoad, $categoryToSearch, $pattern);
	
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
		$message = "No more items to load";
		return new AjaxResponse("-1", $message);
	}
	
	function setResponse($result, $message){
		$response = new AjaxResponse("0", $message);
			
		$index = 0;
		while ($row = $result->fetch_assoc()){
			// Set Item class
			$rate = ($row["rate"] === null)? 0 : $row["rate"];
			$item = new Item($row["itemID"], $row["Nome"], $row["Categoria"], $row["Descrizione"], $row["Origine"], $row["Costo"], $row["Disponibilita"], $rate);
			
			$response->data[$index] = $item;
			$index++;
		}
		
		return $response;
	}
?>