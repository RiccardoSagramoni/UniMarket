<?php
	// File che gestisce a livello server la modifica di una recensione scritta dall'attuale utente
	// I dati necessari vengono inviati con metodo GET dalla pagina /php/item.php
	session_start();
	require_once __DIR__ . ".\..\..\config.php";
	require_once DIR_BASE . "php\util\uniMarketDbManager.php";
    require_once DIR_BASE . "php\util\sessionUtil.php";
	require_once DIR_BASE . "php\util\databaseFunctionManagement.php";
	
	if (!isLogged()){
		header('Location: //'.LOCAL_ROOT.'/php/login.php');
		exit;
    }
	
	// Modifica la recensione
	if(isset($_GET["id"]) && isset($_GET["s"]) && isset($_GET["t"])){
		$itemId = $_GET["id"];
		$rate = $_GET["s"];
		$text = $_GET["t"];
		
		replaceRecensione($_SESSION["uniMarketuserId"], $itemId, $rate, $text);
		
		header('Location: //'.LOCAL_ROOT.'/php/item.php?id='.$itemId);
		exit;
	}
	
	// Elimina la recensione
	if(isset($_GET["id"]) && isset($_GET["delete"])){
		$itemId = $_GET["id"];
		
		deleteRecensione($_SESSION["uniMarketuserId"], $itemId);
		
		header('Location: //'.LOCAL_ROOT.'/php/item.php?id='.$itemId);
		exit;
	}
	
	header('Location: //'.LOCAL_ROOT.'/index.php');
	exit;
?>