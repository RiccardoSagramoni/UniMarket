<?php
	session_start();
	require_once __DIR__ . ".\..\config.php";
	require_once DIR_BASE . "php\util\uniMarketDbManager.php";
    require_once DIR_BASE . "php\util\sessionUtil.php";
	require_once DIR_BASE . "php\util\databaseFunctionManagement.php";
	require_once DIR_BASE . "php\util\productPage.php";
	
	if (!isLogged()){
		header('Location: //'.LOCAL_ROOT.'/php/login.php');
		exit;
    }
	
	if(isset($_POST["carrello"])){
		$ok = sottomettiCarrello(getCurrentShoppingCart($_SESSION["uniMarketuserId"]));
		
		if($ok){
			header('Location: //'.LOCAL_ROOT.'/php/util/successShop.php');
			exit;
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
	<link rel="icon" type="image/png" href="./../img/favicon.png">
	<title>Carrello | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../css/UniMarket.css" media="screen">
	<script src="./../javascript/item.js"></script>
</head>
<body>
	<?php
		include "./layout/header.php";
		
		$thisShoppingId = getCurrentShoppingCart($_SESSION["uniMarketuserId"]);
		$itemsCarrello = getAllItemsOfShoppingCart($thisShoppingId);
		$costoTotale = 0;
		
		$i = 0;
		
		// Carica gli oggetti presenti nel carrello
		while($row = $itemsCarrello->fetch_assoc()){
		?>
			<div class="itemtaken_carrello" id="itemtaken-<?php echo $i; ?>">
				<img id="img-item-<?php echo $row["itemId"]; ?>" src="./../img/items/item-<?php echo $row["itemId"]; ?>.jpg" alt="item-<?php echo $row["itemId"]; ?>"
						onerror="document.getElementById('img-item-<?php echo $row["itemId"]; ?>').setAttribute('src', './../img/ImageNotAvailable.png')">
				<div class="flex_centered_container">
					<a class="itemtaken_carrello_title" href="./item.php?id=<?php echo $row["itemId"]; ?>">
						<?php echo $row["Nome"]; ?>
					</a>
				</div>
				<br>
				<div class="flex_centered_container">
					<div class="itemtaken_carrello_categoria">
						<strong>Categoria: </strong><?php echo $row["Categoria"]; ?>
					</div>
					<div class="itemtaken_carrello_costo">
						<strong>Costo singolo: </strong>€ <?php echo $row["Costo"]; ?>
					</div>
					<div class="itemtaken_carrello_howMany">
						<strong>Quantità: </strong><?php echo $row["howMany"]; ?>
					</div>
				</div>
				<br>
				<div class="itemtaken_command">
						<input type="number" value="1" min="1" title="Inserisci quanti campioni di questo prodotto vanno tolti dal carrello">
						<button onclick="deleteItemTaken(<?php echo $row["itemId"]; ?>, document.getElementById('itemtaken-<?php echo $i; ?>').getElementsByClassName('itemtaken_command')[0].getElementsByTagName('input')[0].value)">
							ELIMINA
						</button>
				</div>
			</div>
		<?php
			$costoTotale += ($row["howMany"] * $row["Costo"]);
			$i++;
		}
		
		// Se non ci sono elementi nel carrello allora $i e' rimasto a 0
		if($i == 0){
		?>
			<div class="empty_carrello"></div>
		<?php
		}
		
		// inserisco il sidebar destro per inviare il carrello
		if($i != 0){
		?>
			<form method="POST" action="./carrello.php" id="confermaCarrello">
				<h2>CARRELLO</h2>
				<div class="flex_row">
					<div class="left_cell">
						Totale prodotti:
					</div>
					<div class="right_cell">
						€ <?php echo number_format($costoTotale, 2); ?>
					</div>
				</div>
				<div class="flex_row">
					<div class="left_cell">
						Spese di spedizione:	
					</div>
					<div class="right_cell">
						€ <?php
							$speseSpedizione = getSpeseSpedizione();
							echo number_format($speseSpedizione, 2);
						?>
					</div>
				</div>
				<hr>
				<div class="flex_row">
					<div class="left_cell">
						Totale carrello:
					</div>
					<div class="right_cell">
						€ <?php echo number_format($costoTotale + $speseSpedizione, 2)?>
					</div>
				</div>
				<hr>
				
				<input name="carrello" type="hidden" value="1">
				
				<input class="carrello_button" type="submit" value="INVIA">
			</form>
		<?php
		}
	?>
</body>
</html>