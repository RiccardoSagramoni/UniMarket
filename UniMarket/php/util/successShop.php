<?php
	// Pagina che viene visualizzata dopo la corretta sottomissione di un carrello
	session_start();
	require_once __DIR__ . ".\..\..\config.php";
	require_once DIR_BASE . "php\util\sessionUtil.php";
	
	if (!isLogged()){
		header('Location: //'.LOCAL_ROOT.'/php/login.php');
		exit;
    }
?>
<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta charset="utf-8"> 
	<meta name = "author" content = "Riccardo Sagramoni">
	<meta name = "keywords" content = "Supermercato, market, spesa online, spesa, pisa">
	<meta name = "description" content = "UniMarket: la spesa a casa vostra">
	<link rel="icon" type="image/png" href="./../img/favicon.png">
	<title>Carrello | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/SuccessShop.css" media="screen">
</head>
<body>
	<h1>Il carrello è stato correttamente inviato</h1>
	<p>La pagina si autoreindirizzerà automaticamente in 5 secondi: <a href="./../../index.php">clicca qui</a> se ciò non avviene!</p>

	<script>
		setTimeout(function(){location.replace("./../../index.php")},5000);
	</script>
</body>
</html>