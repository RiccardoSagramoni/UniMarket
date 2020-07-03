<?php
	// Pagina per il LOGOUT dell'utente
    session_start();
    
    unset($_SESSION["uniMarketuserId"]);
	unset($_SESSION["nomeutente"]);
	
	if(isset($_SESSION["admin"])) unset($_SESSION["admin"]);
	
    header("Location: ./../index.php");
    exit;
?>