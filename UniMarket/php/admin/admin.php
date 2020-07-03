<?php
	session_start();
	require_once __DIR__ . ".\..\..\config.php";
	require_once DIR_BASE . "php\util\uniMarketDbManager.php";
    require_once DIR_BASE . "php\util\sessionUtil.php";
	require_once DIR_BASE . "php\util\databaseFunctionManagement.php";
	
	if (!isLogged() || !isAdmin()){
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
	<link rel="icon" type="image/png" href="./../../img/favicon.png">
	<title>Sezione ADMIN | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
</head>
<body>
	<?php
		include "./../layout/header.php";
	?>
	
	<div class="admin_main_page">
		<h1>Benvenuto nella sezione riservata agli amministratori</h1>
		<p>In questa sezione è possibile:</p>
		<ul>
			<li><a href="./modifica-prodotto.php">Modificare i dati relativi ai prodotti presenti nel nostro catalogo</a></li>
			<li><a href="./immagine-prodotto.php">Modificare l'immagine di un prodotto</a></li>
			<li><a href="./aggiungi-prodotto.php">Aggiungere nuovi prodotti al catalogo</a></li>
			<li><a href="./aggiungi-admin.php">Aggiungere un nuovo amministratore del portale</a></li>
		</ul>
	</div>
</body>
</html>