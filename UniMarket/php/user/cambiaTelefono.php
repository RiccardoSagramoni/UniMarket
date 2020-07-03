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
	
	if(isset($_POST["telefono"])){
		$telefono = $_POST["telefono"];
		
		changePhoneNumberUser($_SESSION["uniMarketuserId"], $telefono);
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
	<title>Cambia telefono | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/LogAndSignPageLayout.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/ChangeUserDataLayout.css" media="screen">
	<script src="./../../javascript/profilo.js"></script>
</head>
<body>
	<form id="cambia-telefono" name="cambia" action="./cambiaTelefono.php" method="POST">
		<h2>Inserisci il nuovo telefono</h2>
		
		<div class="input">
			<label>Telefono *</label>
			<input type="tel" name="telefono" pattern="[0-9]{10,11}" required title="un numero di telefono valido è composto da 10 o 11 cifre numeriche" value=<?php if(isset($_POST["telefono"])) echo '"'.$_POST["telefono"].'"'; else echo '""';?>>
		</div>
		
		<div class="input_button">
			<input type="submit" value="Conferma">
			<button onclick="annulla()">Annulla</button>
		</div>
	</form>

</body>
</html>