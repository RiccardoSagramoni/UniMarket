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
	
	if(isset($_POST["email"])){
		$email = $_POST["email"];
		
		if(getUserId($email) == null){
			changeEmailUser($_SESSION["uniMarketuserId"], $email);
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
	<title>Cambia email | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/LogAndSignPageLayout.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/ChangeUserDataLayout.css" media="screen">
	<script src="./../../javascript/profilo.js"></script>
</head>
<body>
	<form id="cambia-email" name="cambia" action="./cambiaEmail.php" method="POST">
		<h2>Inserisci la nuova email</h2>
		<div class="input">
			<label>Email *</label>
			<input type="email" name="email" required value=<?php if(isset($_POST["email"])) echo '"'.$_POST["email"].'"'; else echo '""';?>>
		</div>
		<div class="input_button">
			<input type="submit" value="Conferma">
			<button onclick="annulla()">Annulla</button>
		</div>
	</form>
	
	<script>
		<?php if($error){ ?>
			alert("L'email inserita è già stata utilizzata da un altro utente");
		<?php } ?>
	</script>
</body>
</html>