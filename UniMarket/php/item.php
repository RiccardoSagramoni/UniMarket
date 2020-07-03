<?php
	session_start();
	require_once __DIR__ . ".\..\config.php";
	require_once DIR_BASE . "php\util\uniMarketDbManager.php";
    require_once DIR_BASE . "php\util\sessionUtil.php";
	require_once DIR_BASE . "php\util\databaseFunctionManagement.php";
	
	if (!isLogged()){
		header('Location: //'.LOCAL_ROOT.'/php/login.php');
		exit;
    }
	
	$itemId = $_GET["id"];
	
	if(isset($_POST["rating"]) && isset($_POST["testo"])){
		$insertRecensione = insertRecensione($_SESSION["uniMarketuserId"], $itemId, $_POST["rating"], $_POST["testo"]);
		header('Location: //'.LOCAL_ROOT.'/php/item.php?id='.$itemId);
		exit;
	}
	
	$itemInfo = getItemById($itemId);
	
	$nome = $itemInfo["Nome"];
	$categoria = $itemInfo["Categoria"];
	$descrizione = $itemInfo["Descrizione"];
	$origine = $itemInfo["Origine"];
	$costo = $itemInfo["Costo"];
	$disponibilita = $itemInfo["Disponibilita"];
	$rate = $itemInfo["rate"];
	
	if($rate == null || $rate < 0) $rate = 0;
	
?>
<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta charset="utf-8"> 
	<meta name = "author" content = "Riccardo Sagramoni">
	<meta name = "keywords" content = "Supermercato, market, spesa online, spesa, pisa">
	<meta name = "description" content = "UniMarket: la spesa a casa vostra">
	<link rel="icon" type="image/png" href="./../img/favicon.png">
	<title><?php echo $nome ?> | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../css/UniMarket.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../css/ItemPage.css" media="screen">
	<script src="./../javascript/ajax/ajaxManager.js"></script>
	<script src="./../javascript/ajax/shoppingCart.js"></script>
	<script src="./../javascript/ajax/ItemDashboard.js"></script>
	<script src="./../javascript/item.js"></script>
</head>
<body>
	<?php
		include "./layout/header.php";
	?>
	
	<a id="buttonBack" href="./product.php?c=<?php echo $categoria; ?>">&larr;  Torna alla categoria</a>
	
	<div class="center_container">
		<div id="item-content">
			<img id="item-img" alt="item-<?php echo $itemId; ?>"
					src = <?php if($disponibilita > 0) echo "./../img/items/item-".$itemId.".jpg"; else echo "./../img/sold-out-square.png"; ?>
					onerror="document.getElementById('item-img').setAttribute('src', './../img/ImageNotAvailable.png')">
			<div id="item-info">
				<h1 id="item-name"><?php echo $nome; ?></h1>
				
				<div id="item-rate">
					<div id="item-stars"></div>
					<strong><?php echo (($rate > 0) ? $rate." / 5" : 'N/A'); ?></strong>
				</div>
				
				<p id="item-origin">Prodotto in <strong><?php echo $origine; ?></strong></p>
				
				<p id="item-description"><?php echo $descrizione; ?></p>
				
				<div class="flex-container compra">
					<p id="item-costo">€ <?php echo $costo; ?></p>
					<input id="howMany" type="number" min="1" max="99" value="1" title="Seleziona quanti oggetti vuoi comprare (max 99)">
					<button id="aggiungi" <?php if($disponibilita > 0) echo 'onclick="ShoppingCart.addItemToShoppingCart('.$itemId.', document.getElementById(\'howMany\').value)"'?>>
						Aggiungi al carrello
					</button>
				</div>
			</div>
		</div>
		
		<?php
			$thisRecensione = checkIfAlreadyRated($_SESSION["uniMarketuserId"], $itemId)->fetch_assoc();
			
			// Sezione per scrivere una nuova recensione
			if(!isset($thisRecensione) || $thisRecensione === null){
		?>
		<div class="recensione" id="recensioni">
			<form id="submit-recensione" name="formRecensione" onsubmit="return send(document.formRecensione)" method="POST" action="./item.php?id=<?php echo $itemId; ?>">
				<h1>SCRIVI UNA RECENSIONE</h1>
				<div class="flex-container">
					<span>Inserisci una votazione: </span>
					<div class="star-rating">
						<input required type="radio" id="no-rate" class="input-no-rate" name="rating" value="0" checked>

						<input required type="radio" id="rate1" name="rating" value="1">
						<label for="rate1">1 star</label>

						<input required type="radio" id="rate2" name="rating" value="2">
						<label for="rate2">2 stars</label>

						<input required type="radio" id="rate3" name="rating" value="3">
						<label for="rate3">3 stars</label>

						<input required type="radio" id="rate4" name="rating" value="4">
						<label for="rate4">4 stars</label>

						<input required type="radio" id="rate5" name="rating" value="5">
						<label for="rate5">5 stars</label>
		
					</div>
				</div>
				<textarea required class="text-recensione" name="testo" minlength="1" maxlength="2040" placeholder="Scrivi una recensione..."></textarea>
				<input type="submit" class="submit_button" value="INVIA">
			</form>		
		</div>
		
		<?php
			}
			else {		// Visualizza la recensione gia' scritta dall'utente, con i pulsanti MODIFICA, ANNULLA, ELIMINA
			?>
				<div id="myReview" class="recensione flex-container">
					<h2><?php echo $thisRecensione["NomeUtente"]." ".$thisRecensione["CognomeUtente"] ?></h2>
					<p class="timestamp_recensione"><?php echo date("d-m-Y G:i",strtotime($thisRecensione["Timestamp"]))?></p>
					
					<div class="star-rating disabled">
						<input required type="radio" id="no-rate" class="input-no-rate" name="rating" value="0">

						<input required type="radio" id="rate1" name="rating" value="1" <?php if($thisRecensione["Votazione"] == 1) echo "checked";?>>
						<label for="rate1">1 star</label>

						<input required type="radio" id="rate2" name="rating" value="2" <?php if($thisRecensione["Votazione"] == 2) echo "checked";?>>
						<label for="rate2">2 stars</label>

						<input required type="radio" id="rate3" name="rating" value="3" <?php if($thisRecensione["Votazione"] == 3) echo "checked";?>>
						<label for="rate3">3 stars</label>

						<input required type="radio" id="rate4" name="rating" value="4" <?php if($thisRecensione["Votazione"] == 4) echo "checked";?>>
						<label for="rate4">4 stars</label>

						<input required type="radio" id="rate5" name="rating" value="5" <?php if($thisRecensione["Votazione"] == 5) echo "checked";?>>
						<label for="rate5">5 stars</label>
		
					</div>
					<textarea class="testo_recensione"  minlength="1" maxlength="2040" disabled="disabled"><?php echo $thisRecensione["Descrizione"];
						?></textarea>
					<button onclick="modifyMyReview()" class="buttonReview" id="modMyReview">Modifica</button>
					<button onclick="location.reload()" class="buttonReview" id="undoMyMod">Annulla</button>
					<button onclick="deleteMyReview()" class="buttonReview" id="removeMyMod">Elimina</button>
					
					<script>
						autosizeTextArea(document.getElementById('myReview').getElementsByTagName('textarea')[0]);
					</script>
				</div>
			<?php } ?>
		
		<script>
			// Inserisce le stelle del prodotto
			setStarItem(document.getElementById("item-stars"), <?php echo $rate; ?>);
		</script>
		
		<div id="users-reviews">
			<?php
				$recensioni = getAllReviewsAndData($itemId);
				
				$iter = 1;
				
				// Visualizza tutte le recensioni di questo prodotto
				while ($row = $recensioni->fetch_assoc()){
					
					if($row["userId"] == $_SESSION["uniMarketuserId"]
						&& isset($thisRecensione) && $thisRecensione != null) continue;
					
					?>
					<div class="recensione flex-container">
						<h2><?php echo $row["NomeUtente"]." ".$row["CognomeUtente"] ?></h2>
						<p class="timestamp_recensione"><?php echo date("d-m-Y G:i",strtotime($row["Timestamp"]))?></p>
						<div class="flex-container star-medium"></div>
						<p class="testo_recensione">
							<?php
								echo $row["Descrizione"];
							?>
						</p>
						<script>
							// Imposta le stelle della recensione
							setStarItem(document.getElementsByClassName("recensione")[<?php echo $iter; ?>].getElementsByClassName("star-medium")[0], <?php echo $row["Votazione"] ?>);
						</script>
					</div>
					<?php
					$iter++;
				}
			?>
		</div>
	</div>
</body>
</html>