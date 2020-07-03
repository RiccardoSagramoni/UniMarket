<?php
	session_start();
	require_once __DIR__ . ".\..\config.php";
	require_once DIR_BASE . "php\util\uniMarketDbManager.php";
    require_once DIR_BASE . "php\util\sessionUtil.php";

    if (isLogged()){
		header('Location: //'.LOCAL_ROOT.'/index.php');
		exit;
    }

	$error = null;
	
	if (isset($_POST["email"]) && isset($_POST["password"])){
		$email = $_POST["email"];
		$password = $_POST["password"];
		
		$error = login($email, $password);
		
		if ($error === null) {
			header('location: ./../index.php');
		    exit;
		}
	}
	
	// Funzione che effettua il login dell'utente
	function login($email, $password){
		if ($email != null && $password != null){
			$userData = authenticate($email, $password);
			
    		if ($userData != null && extract($userData) == 3){
				if(!isset($_SESSION))
					session_start();
				
    			setSession($nome, $userId);
				if($isAdmin){
					logAsAdmin();
				}
    			return null;
    		}

    	}
    	return 'Email e/o password non valida';
	}
	
	// Funzione che esegue l'autenticazione dell'utente a livello del server
	function authenticate($email, $password){
		global $uniMarketDb;
		$email = $uniMarketDb->sqlInjectionFilter($email);
		$password = $uniMarketDb->sqlInjectionFilter($password);
		
		$query = "	SELECT userId, nome, isAdmin
					FROM User
					WHERE email = '" . $email . "'
					AND password = '" . $password . "';";
					
		$uniMarketDb->openConnection();
		$result = $uniMarketDb->performQuery($query);
		
		$numRow = mysqli_num_rows($result);
		if ($numRow != 1)
			return null;
		
		$uniMarketDb->closeConnection();
		
		
		$dataRow = $result->fetch_assoc();
		return $dataRow;
	}
?>

<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta charset="utf-8"> 
	<meta name = "author" content = "Riccardo Sagramoni">
	<link rel="icon" type="image/png" href="./../img/favicon.png">
	<title>Login | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../css/LogAndSignForm.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../css/LogAndSignPageLayout.css" media="screen">
</head>
<body>
	<div id="login-container" class="containerWhiteCentered">
		<form name="login" action="//<?php echo LOCAL_ROOT . '/php/login.php'?>" method="POST">
			<div class="input_login">
				<label>Email</label>
				<input type="text" name="email" value=<?php if(isset($_POST["email"])) echo '"'.$_POST["email"].'"'; else echo '""';?> required autofocus>
			</div>
			<div class="input_login">
				<label>Password</label>
				<input type="password" name="password" value=<?php if(isset($_POST["password"])) echo '"'.$_POST["password"].'"'; else echo '""';?> required>
			</div>
			<div class="flexbox">
				<input class="submit_button" type="submit" value="Enter">
			</div>
		</form>
		<a class="sign_link" href="./signUp.php">Non sei ancora registrato? Clicca qui!</a>
	</div>
	<?php
		if ($error !== null){
			echo '<script> alert("'.$error.'"); </script>';
		}
	?>
</body>
</html>