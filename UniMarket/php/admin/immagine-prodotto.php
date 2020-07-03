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
	
	$error = null;
	$message = null;
	
	// Carica l'immagine nel server
	if(isset($_POST["itemId"]) && isset($_FILES["fileToUpload"])){
		
		$uploadOk = 1;
		$target_dir = "./../../img/items/";
		$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
		
		$target_file = $target_dir . "item-" . $_POST["itemId"] . "." . $imageFileType;
		
		// Check if image file is a actual image or fake image
		if($_FILES["fileToUpload"]["tmp_name"] == '' || !getimagesize($_FILES["fileToUpload"]["tmp_name"])){
			$uploadOk = 0;
			$message = "Il file non è stato caricato perché non è un'immagine";
		}

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			$uploadOk = 0;
			$message = "Il file non è stato caricato perché è troppo grande";
		}
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			$uploadOk = 0;
			$message = "Il file non è stato caricato perché non è in uno dei seguenti formati: JPG, JPEG, PNG";
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0 ) {
			$error = true;
		} 
		// Check is the item exists
		elseif(getItemById($_POST["itemId"]) == null){
			$error = true;
			$message = "Il prodotto selezionato non esiste";
		}
		// if everything is ok, try to upload file
		else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$error = false;
				$message = "il file ". basename( $_FILES["fileToUpload"]["name"]). " è stato caricato.";
			} else {
				$error = true;
				$message = "C'è stato un errore durante il caricamento del file.";
			}
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
	<title>Modifica l'immagine di un prodotto | Admin</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
</head>
<body>
	<?php
		include "./../layout/header.php";
	?>
	
	<form class="form_admin" action="./immagine-prodotto.php" method="POST" enctype="multipart/form-data">
		<div>
			<label>Inserisci il codice identificativo del prodotto:</label>
			<input type="number" step="1" min="1" name="itemId" required autofocus>
		</div>
		<div>
			<label>Seleziona l'immagine in formato in PNG, JPG o JPEG di dimensione 300x300 pixel</label>
			<input type="file" name="fileToUpload" id="fileToUpload" required>
		</div>
		
		<input class="submit_button" type="submit" value="Carica Immagine" name="submit">
	</form>
	
	<script>
	<?php
		if($error !== null){ 
			echo "alert('".$message."');";
			
			if($error == false){
				echo 'location.href="./admin.php"';
			}
		}
	?>
	</script>
	
</body>
</html>