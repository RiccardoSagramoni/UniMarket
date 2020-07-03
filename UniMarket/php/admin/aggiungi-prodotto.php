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
	
	$error=null;
	
	if(isset($_POST["Nome"]) && isset($_POST["Categoria"]) && isset($_POST["Descrizione"])
		&& isset($_POST["Origine"]) && isset($_POST["Costo"]) && isset($_POST["Disponibilita"])){
			
		$result = insertItem($_POST["Nome"],$_POST["Categoria"],$_POST["Descrizione"],$_POST["Origine"],$_POST["Costo"],$_POST["Disponibilita"]);
		if($result == false) $error=true;
		else $error = false;
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
	<title>Aggiungi un prodotto | Admin</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
</head>
<body>
	<?php
		include "./../layout/header.php";
	?>
	
	<form class="form_item" action="./aggiungi-prodotto.php" method="POST">
		<h2>Aggiungi un nuovo prodotto</h2>
		
		<div class="edit_item_data">
			<label>Nome</label>
			<input id="input-item-nome" type="text" name="Nome" required>
		</div>
		
		<div class="edit_item_data">
			<label>Categoria</label>
			<select id="input-item-categoria" name="Categoria" required>
				<option value="" disabled selected>Scegli la categoria...</option>
				<option value="frutta">Frutta e verdura</option>
				<option value="pasta">Pasta, riso e cereali</option>
				<option value="carne">Carne, salumi e uova</option>
				<option value="pesce">Pesce</option>
				<option value="latte">Latte e derivati</option>
				<option value="veggie">Alimenti vegetariani e vegani</option>
				<option value="dolci">Dolci, merendine e biscotti</option>
				<option value="surgelati">Surgelati e gelati</option>
				<option value="mondobimbo">Alimenti per l'infanzia</option>
				<option value="bibite">Acqua e bibite analcoliche</option>
				<option value="alcol">Vino, birra e alcolici</option>
				<option value="varie">Varie e drogheria</option>				
			</select> 
		</div>
		
		<div class="edit_item_data">
			<label>Descrizione</label>
			<textarea id="input-item-descrizione" name="Descrizione" maxlength="4096" required></textarea>
		</div>
		
		<div class="edit_item_data">
			<label>Origine</label>
			<input id="input-item-origine" type="text" name="Origine" required>
		</div>
		
		<div class="edit_item_data">
			<label>Costo</label>
			<input id="input-item-costo" type="number" step="0.01" max="999.99" name="Costo" required>
		</div>
		
		<div class="edit_item_data">
			<label>Disponibilità</label>
			<input id="input-item-disponibilita" type="number" step="1" min="0" name="Disponibilita" required>
		</div>
		
		<div class="input_button">
			<input type="submit" value="Aggiungi">
		</div>
	</form>
	
	<script>
		<?php
			if(isset($error) && $error==true){ ?>
				alert("Errore! Qualcosa è andato storto.");
		<?php } 
			elseif(isset($error) && $error==false){	?>
				alert("Il prodotto è stato correttamente inserito nel sistema");
				location.href = "./aggiungi-prodotto.php"; // per evitare di inserire nuovamente il prodotto quando si ricarica la pagina
		<?php
			}
		?>
	</script>
	
</body>
</html>	
	
	
	
	
	