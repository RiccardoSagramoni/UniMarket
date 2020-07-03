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
?>
<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta charset="utf-8"> 
	<meta name = "author" content = "Riccardo Sagramoni">
	<meta name = "keywords" content = "Supermercato, market, spesa online, spesa, pisa">
	<meta name = "description" content = "UniMarket: la spesa a casa vostra">
	<link rel="icon" type="image/png" href="./../../img/favicon.png">
	<title>Profilo | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/LogAndSignForm.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/ProfiloPageLayout.css" media="screen">
	<script src="./../../javascript/ajax/shoppingCart.js"></script>
</head>
<body>
	<?php
		include DIR_BASE . "php/layout/header.php";
		
		$data = getDataUser($_SESSION["uniMarketuserId"]);
		$data = $data->fetch_assoc();
	?>

	<div id="user-data-preview">
		<h1 class="title_form">DATI PERSONALI</h1><hr>
		<div class="input_sign">
			<div>Nome</div>
			<div class="user_data"><?php echo $data["Nome"]; ?></div>
		</div>
		<div class="input_sign">
			<div>Cognome</div>
			<div class="user_data"><?php echo $data["Cognome"]; ?></div>
		</div>
		<div class="input_sign">
			<div>Email</div>
			<div class="user_data"><?php echo $data["Email"]; ?></div>
		</div>
		<div class="input_sign">
			<div>Data di nascita</div>
			<div class="user_data"><?php echo date("d/m/Y",strtotime($data["DataNascita"])); ?></div>
		</div>
		<div class="input_sign">
			<div>Numero di telefono</div>
			<div class="user_data"><?php echo $data["Telefono"]; ?></div>
		</div>
		
		<div class="input_sign">
			<div>Indirizzo di spedizione</div>
			<div class="user_data"><?php echo $data["Indirizzo"]; ?></div>
		</div>
		<div class="input_sign">
			<div>Città</div>
			<div class="user_data"><?php echo $data["Citta"]; ?></div>
		</div>
		<div class="input_sign">
			<div>CAP</div>
			<div class="user_data"><?php echo $data["CAP"]; ?></div>
		</div>
		
		<div class="flexbox_button_profilo">
			<a href="./cambiaEmail.php" class="change_button">Cambia l'email</a>
			<a href="./cambiaPassword.php" class="change_button">Cambia la password</a>
			<a href="./cambiaTelefono.php" class="change_button">Cambia il numero di telefono</a>
			<a href="./cambiaIndirizzo.php" class="change_button">Cambia l'indirizzo</a>
		</div>
		
	</div>
</body>
</html>