<?php
	// PAGINA di REGISTRAZIONE di un nuovo utente
	session_start();
	require_once __DIR__ . ".\..\config.php";
	require_once DIR_BASE . "php\util\uniMarketDbManager.php";
    require_once DIR_BASE . "php\util\sessionUtil.php";
	require_once DIR_BASE . "php\util\databaseFunctionManagement.php";

    if (isLogged()){
		header('Location: //'.LOCAL_ROOT.'/index.php');
		exit;
    }

	$error = null;
	
	if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["email"]) && isset($_POST["password"]) 
		&& isset($_POST["nascita"]) && isset($_POST["sesso"]) && isset($_POST["telefono"]) && isset($_POST["indirizzo"]) 
		&& isset($_POST["citta"]) && isset($_POST["cap"]))
	{
		$resultset = insertNewUser($_POST["nome"], $_POST["cognome"], $_POST["email"], $_POST["password"], 
						$_POST["nascita"], $_POST["sesso"], $_POST["telefono"], $_POST["indirizzo"], $_POST["citta"], $_POST["cap"]);
		
		// controlla se la registrazione e' fallita
		if ($resultset["result"] == false){
			// errore 1062: l'email inserita e' gia' registrata
			if($resultset["errorNumber"] == 1062){
				$error = 'email';
			}
			else{
				echo '<script>alert("Error '.$resultset["errorNumber"].': '.$resultset["errorText"].'"); </script>';
			}
		}
		else{
			$userId = getUserId($_POST["email"]);
			setSession($_POST["nome"], $userId);
			header('Location: //'.LOCAL_ROOT.'/index.php');
			exit;
		}
	}
	
?>

<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta charset="utf-8"> 
	<meta name = "author" content = "Riccardo Sagramoni">
	<link rel="icon" type="image/png" href="./../img/favicon.png">
	<title>Registrati | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../css/LogAndSignForm.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../css/LogAndSignPageLayout.css" media="screen">
	<script src="./../javascript/signUpForm.js"></script>
</head>
<body>
	<div id="signUp-container" class="containerWhiteCentered">
		
		<form id="form-registrati" name="registrati" action="//<?php echo LOCAL_ROOT . '/php/signUp.php'?>" method="POST">
			<h1 class="title_form">REGISTRATI</h1><hr>
			<div class="input_sign">
				<label>Nome *</label>
				<input type="text" name="nome" pattern="[A-Za-z\s]+" required autofocus value=<?php if(isset($_POST["nome"])) echo '"'.$_POST["nome"].'"'; else echo '""';?>>
			</div>
			<div class="input_sign">
				<label>Cognome *</label>
				<input type="text" name="cognome" pattern="[A-Za-z\s]+" required value=<?php if(isset($_POST["cognome"])) echo '"'.$_POST["cognome"].'"'; else echo '""';?>>
			</div>
			<div class="input_sign">
				<label>Email *</label>
				<input type="email" name="email" required value=<?php if(isset($_POST["email"])) echo '"'.$_POST["email"].'"'; else echo '""';?>>
				<div class="input_error">Questa email è già stata utilizzata</div>
			</div>
			<div class="input_sign">
				<label>Password *</label>
				<input type="password" name="password" minlength="8" maxlength="64" title="La password deve essere lunga almeno 8 caratteri e massimo 64" required value=<?php if(isset($_POST["password"])) echo '"'.$_POST["password"].'"'; else echo '""';?>>
				<div class="input_error">Le password devono coincidere.</div>
			</div>
			<div class="input_sign">
				<label>Conferma Password *</label>
				<input type="password" name="confermaPassword" required>
			</div>
			<div class="input_sign">
				<label>Data di nascita *</label>
				<input type="date" name="nascita" class="input_date" required onchange="errorDate(this)" value=<?php if(isset($_POST["nascita"])) echo '"'.$_POST["nascita"].'"'; else echo '""';?>>
			</div>
			<div class="input_sign">
				<label>Sesso *</label>
				<div class="radio_sign">
					<span><input type="radio" name="sesso" value="M" required <?php if(isset($_POST["sesso"]) && $_POST["sesso"]=='M') echo 'checked' ?>>Uomo</span>
					<span><input type="radio" name="sesso" value="F" required <?php if(isset($_POST["sesso"]) && $_POST["sesso"]=='F') echo 'checked' ?>>Donna</span>
				</div>
			</div>
			<div class="input_sign">
				<label>Numero di telefono *</label>
				<input type="tel" name="telefono" pattern="[0-9]{10,11}" value=<?php if(isset($_POST["telefono"])) echo '"'.$_POST["telefono"].'"'; else echo '""';?> title="Un numero di telefono valido è composto da 10 o 11 cifre numeriche" required>
			</div>
			
			<div class="input_sign">
				<label>Indirizzo di spedizione *</label>
				<input type="text" name="indirizzo" required value=<?php if(isset($_POST["indirizzo"])) echo '"'.$_POST["indirizzo"].'"'; else echo '""';?>>
			</div>
			<div class="input_sign">
				<label>Città *</label>
				<input type="text" name="citta" pattern="[A-Za-z\s]+" required value=<?php if(isset($_POST["citta"])) echo '"'.$_POST["citta"].'"'; else echo '""';?>>
			</div>
			<div class="input_sign">
				<label>CAP *</label>
				<input type="text" name="cap" pattern="[0-9]{5}" title="Il CAP è formato da cinque cifre numeriche" required value=<?php if(isset($_POST["cap"])) echo '"'.$_POST["cap"].'"'; else echo '""';?>> 
			</div>
			
			<div class="flexbox">
				<input class="submit_button" type="submit" name="submit" value="Invia">
			</div>
			
			<a class="sign_link flex_link_signup" href="./login.php">Sei già registrato? Clicca qui!</a>
		</form>
		
		<script>
			document.registrati.onsubmit = new Function("return validateForm(document.registrati)");
			
			<?php
				if ($error == 'email'){
					echo 'var thisEmail = document.registrati.email;';
					echo 'errorInput(thisEmail)';
				}
			?>
		</script>
		
	</div>
</body>
</html>