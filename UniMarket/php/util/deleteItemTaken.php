<?php
	// File che gestisce a livello server l'eliminazione di un prodotto dal carrello dell'utente attuale.
	// I dati necessari vengono inviati con metodo GET dalla pagina /php/carrello.php
	session_start();
	require_once __DIR__ . ".\..\..\config.php";
	require_once DIR_BASE . "php\util\uniMarketDbManager.php";
    require_once DIR_BASE . "php\util\sessionUtil.php";
	require_once DIR_BASE . "php\util\databaseFunctionManagement.php";
	
	if (!isLogged()){
		header('Location: //'.LOCAL_ROOT.'/php/login.php');
		exit;
    }
	
	if(isset($_GET["it"]) && isset($_GET["hm"])){
		$itemId = $_GET["it"];
		$howMany = $_GET["hm"];
		
		removeItemTaken($_SESSION["uniMarketuserId"], $itemId, $howMany);
		
		header('Location: //'.LOCAL_ROOT.'/php/carrello.php');
		exit;
	}
	
	header('Location: //'.LOCAL_ROOT.'/php/index.php');
	exit;
?>