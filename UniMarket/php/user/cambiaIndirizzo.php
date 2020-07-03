<?php
	session_start();
	require_once __DIR__ . ".\..\..\config.php";
	require_once DIR_BASE . "php\util\uniMarketDbManager.php";
    require_once DIR_BASE . "php\util\sessionUtil.php";
	require_once DIR_BASE . "php\util\databaseFunctionManagement.php";
	
	if (!isLogged()){
		header('Location: //'.LOCAL_ROOT.'/php/login.php');
		exit;
    }
	
	$error = null;
	
	if(isset($_POST["indirizzo"]) && isset($_POST["citta"]) && isset($_POST["cap"])){
		$indirizzo = $_POST["indirizzo"];
		$citta = $_POST["citta"];
		$cap = $_POST["cap"];
		
		changeAddressUser($_SESSION["uniMarketuserId"], $indirizzo, $citta, $cap);
		header('Location: //'.LOCAL_ROOT.'/php/user/profilo.php');
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
	<title>Cambia indirizzo | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/LogAndSignPageLayout.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/ChangeUserDataLayout.css" media="screen">
	<script src="./../../javascript/profilo.js"></script>
</head>
<body>
	<form id="cambia-indirizzo" name="cambia" action="./cambiaIndirizzo.php" method="POST">
		<h2>Inserisci il nuovo indirizzo</h2>
		
		<div class="input">
			<label>Indirizzo *</label>
			<input type="text" name="indirizzo" required value=<?php if(isset($_POST["indirizzo"])) echo '"'.$_POST["indirizzo"].'"'; else echo '""';?>>
		</div>
		
		<div class="input">
			<label>Città *</label>
			<input type="text" name="citta" required value=<?php if(isset($_POST["citta"])) echo '"'.$_POST["citta"].'"'; else echo '""';?>>
		</div>
		
		<div class="input">
			<label>CAP *</label>
			<input type="text" name="cap" pattern="[0-9]{5}" title="il CAP è formato da cinque cifre numeriche" required value=<?php if(isset($_POST["cap"])) echo '"'.$_POST["cap"].'"'; else echo '""';?>> 
		</div>
		
		<div class="input_button">
			<input type="submit" value="Conferma">
			<button onclick="annulla()">Annulla</button>
		</div>
	</form>

</body>
</html>