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
	
	if(isset($_POST["itemId"]) && isset($_POST["Nome"]) && isset($_POST["Categoria"]) && isset($_POST["Descrizione"])
		&& isset($_POST["Origine"]) && isset($_POST["Costo"]) && isset($_POST["Disponibilita"])){
			
		$result = updateItemData($_POST["itemId"],$_POST["Nome"],$_POST["Categoria"],$_POST["Descrizione"],$_POST["Origine"],$_POST["Costo"],$_POST["Disponibilita"]);
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
	<title>Modifica i prodotti | Admin</title>
	<link rel="stylesheet" type="text/css" href="./../../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
	<script src="./../../javascript/ajax/ajaxManager.js"></script>
	<script src="./../../javascript/ajax/editItemLoader.js"></script>
	<script src="./../../javascript/ajax/EditItemDashboard.js"></script>
	<script src="./../../javascript/ajax/ItemDashboard.js"></script>
	<script src="./../../javascript/admin.js"></script>
	<script src="./../../javascript/page_navigation.js"></script>
</head>
<body>
	<?php
		include "./../layout/header.php";
	?>
	
	<div id="explore-wrapper">
			<input id="explore" type="text" placeholder="Cerca prodotto..." onkeyup="EditItemLoader.search(this.value)">
	</div>
	
	<?php
		include "./../layout/page_navigation.php";
	?>
	
	<table class="editItem_dashboard">
		<thead>
			<tr> <th>Cod.</th> <th>Nome</th> <th>Categoria</th> <th>Descrizione</th> <th>Origine</th>
			<th>Costo</th> <th>Rating</th> <th>Disponibilità</th> <th></th> </tr>
		</thead>
		<tbody id="editItemDashboard">
			<!-- Fill dinamically with Ajax Request -->
		</tbody>
	</table>
	
	<?php
		include "./../layout/page_navigation.php";
	?>
	
	<script>
		// Associa alle frecce di navigazione le corrette funzioni
		var previousArrow = document.getElementsByClassName("previous");
		previousArrow[0].onclick = function(){EditItemLoader.previous(getNavigationPattern(this))};
		previousArrow[1].onclick = function(){EditItemLoader.previous(getNavigationPattern(this))};
		
		var nextArrow = document.getElementsByClassName("next");
		nextArrow[0].onclick = function(){EditItemLoader.next(getNavigationPattern(this))};
		nextArrow[1].onclick = function(){EditItemLoader.next(getNavigationPattern(this))};
	</script>
	
	<!-- POPUP BOX per la modifica del prodotto selezionato -->
	<div class="edit_popup">
		<div class="edit_popup_content">
			<span class="close_button" onclick="closePopup()">&times;</span>
			<h2>Modifica il prodotto</h2>
			<form action="./modifica-prodotto.php" method="POST">
				<input id="input-item-id" name="itemId" type="hidden">
				
				<div class="edit_item_data">
					<label>Nome</label>
					<input id="input-item-nome" type="text" name="Nome" required>
				</div>
				
				<div class="edit_item_data">
					<label>Categoria</label>
					<select id="input-item-categoria" name="Categoria" required>
						<option value="" disabled selected>Categoria:</option>
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
					<input type="submit" value="Conferma">
				</div>
			</form>
		</div>
	</div>
	<br>
	
	<script>
		// Inizializza la pagina
		EditItemLoader.search("");
		
		<?php
			if(isset($result) && $result == false){
				alert("Qualcosa è andato storto");
			}
		?>
	</script>
	
</body>