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
	
	if(isset($_POST["oldPassword"]) && isset($_POST["password"])){
		$oldPassword = $_POST["oldPassword"];
		$newPassword = $_POST["password"];
		
		if(checkPassword($_SESSION["uniMarketuserId"], $oldPassword)){
			changePasswordUser($_SESSION["uniMarketuserId"], $newPassword);
			header('Location: //'.LOCAL_ROOT.'/php/user/profilo.php');
			exit;
		}
		else{
			$error = true;
		}
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
	<title>Cambia password | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/LogAndSignPageLayout.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/ChangeUserDataLayout.css" media="screen">
	<script src="./../../javascript/signUpForm.js"></script>
	<script src="./../../javascript/profilo.js"></script>
</head>
<body>
	<form class="formlarger" id="cambia" name="cambia" action="./cambiaPassword.php" method="POST">
		<h2>Inserisci la nuova password</h2>
		<div class="input">
			<label>Vecchia password *</label>
			<input type="password" name="oldPassword" required>
		</div>
		<br>
		<div class="input">
			<label>Nuova password *</label>
			<input type="password" name="password" minlength="8" maxlength="64" title="La password deve essere lunga almeno 8 caratteri e massimo 64" required>
			<div class="input_error">Le password devono coincidere.</div>
		</div>
		<div class="input">
			<label> Conferma password *</label>
			<input type="password" name="confermaPassword" required>
		</div>
		
		<div class="input_button">
			<input id="submit" type="submit" value="Conferma">
			<button onclick="annulla()">Annulla</button>
		</div>
	</form>
	
	<script>
		document.cambia.onsubmit = new Function("return validateForm(document.cambia)");
		
		<?php if($error){ ?>
			alert("La vecchia password inserita non è corretta");
		<?php } ?>
	</script>
</body>
</html>