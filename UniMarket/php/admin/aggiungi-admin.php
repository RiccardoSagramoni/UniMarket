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
	
	$error = null; // 0 se l'operazione e' andata a buon fine, 1 se e' sbagliata la password, 2 se non esiste un account con l'email inserita
	
	if(isset($_POST["password"]) && isset($_POST["email"])){
		$password = $_POST["password"];
		$email = $_POST["email"];
		
		$checkPassword = (checkPassword($_SESSION["uniMarketuserId"],$password,true)->fetch_assoc() != null);
		$checkEmail = (getUserId($email) != null);
		
		if($checkPassword && $checkEmail){
			setUserAsAdmin($email);
			$error = 0;
		}
		elseif(!$checkPassword) $error = 1;
		else $error = 2;
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
	<title>Aggiungi Admin | Admin</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
	<script src="./../../javascript/admin.js"></script>
	<script src="./../../javascript/signUpForm.js"></script>
</head>
<body>
	<?php
		include "./../layout/header.php";
	?>
	
	<form id="form-nuovo-admin" class="form_admin" name="nuovoAdmin" action="./aggiungi-admin.php" method="POST">
		<div>
			<label>Inserisci la <strong>tua</strong> password per la conferma della tua identità</label>
			<input type="password" name="password" required autofocus value=<?php if(isset($_POST["password"])) echo '"'.$_POST["password"].'"'; else echo '""';?>>
			<div class="input_error">La password è errata</div>
		</div>
		<br>
		<div>
			<label>Inserisci l'email del nuovo amministratore</label>
			<input type="email" name="email" required value=<?php if(isset($_POST["email"])) echo '"'.$_POST["email"].'"'; else echo '""';?>>
			<div class="input_error">Le email devono coincidere.</div>
			<div class="input_error">L'email inserita non esiste</div>
		</div>
		<div>
			<label>Conferma l'email del nuovo amministratore</label>
			<input type="email" name="email2" required value=<?php if(isset($_POST["email"])) echo '"'.$_POST["email"].'"'; else echo '""';?>>
		</div>
		
		<input class="submit_button" type="submit" value="Conferma" name="submit">
	</form>
	
	<script>
		document.nuovoAdmin.onsubmit = new Function("return validateForm_AddAdmin(document.nuovoAdmin)");
		
		<?php if(isset($error) && $error==1){ ?>
				errorInput(document.nuovoAdmin.password);
		<?php }
			elseif(isset($error) && $error==2){ ?>
				errorInput(document.nuovoAdmin.email);
				errorInput(document.nuovoAdmin.email2);
				document.getElementsByClassName("input_error")[1].style.visibility = 'hidden';
				document.getElementsByClassName("input_error")[2].style.visibility = 'visible';
		<?php } 
			elseif(isset($error) && $error==0){ ?>
				alert("L'utente <?php echo $_POST["email"]; ?> è stato correttamente aggiunto come amministratore");
				location.href = "./admin.php";
		<?php } ?>
	</script>
</body>
</html>