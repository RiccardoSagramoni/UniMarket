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
	<script src="./../../javascript/ordini.js"></script>
	<script src="./../../javascript/ajax/ajaxManager.js"></script>
	<script src="./../../javascript/ajax/shoppingCart.js"></script>
</head>
<body>
	<?php
		include "./../layout/header.php";
		
		$ordiniInviati = getAllClosedShoppingCart($_SESSION['uniMarketuserId']);
		
		$i = 0;
		
		// Visualizza tutti gli ordini inviati
		while($row = $ordiniInviati->fetch_assoc()){
	?>
		<div class="orderSent" id="order-<?php echo $i;?>">
		
			<button class="order_button" onclick="ShoppingCart.copyShoppingCartIntoShoppingCart(<?php echo $row['shoppingID']; ?>)">Copia nel carrello</button>
			
			<h2>Ordine inviato il <?php echo date("d-m-Y G:i",strtotime($row["TimestampChiusura"])); ?></h2>
			
			<div class="orderDescription">
				<span>
					<strong>Prezzo: </strong>
					€ <?php echo $row["Costo"]; ?>
				</span>
				
				<span>
					<strong>Inviato presso: </strong>
					<span class="order_address"><?php echo $row["Indirizzo"]; ?></span>,
					<span class="order_city"><?php echo $row["Citta"] ?></span>
				</span>
			</div>
			
			<br>
			
			<a class="more_detail green_link_js" onclick="showMoreDetailAboutOrder('order-<?php echo $i; ?>')">Maggiori dettagli &#9660;</a>
				
			<div class="more_detail">
				<?php
					$itemsOfShoppingCart = getAllItemsOfShoppingCart($row["shoppingID"]);
				?>
				<table>
				<thead>
					<tr> <th>Nome <th>Categoria <th>Costo <th>Quantità </tr>
				</thead>
				<tbody>
				<?php
					while($row2 = $itemsOfShoppingCart->fetch_assoc()){
				?>
					<tr>
						<td><a href="./../item.php?id=<?php echo $row2["itemId"] ?>"><?php echo $row2["Nome"]; ?></a>
						<td><?php echo $row2["Categoria"]; ?>
						<td><?php echo $row2["Costo"]; ?>
						<td><?php echo $row2["howMany"]; ?>
					</tr>
				<?php }
				?>
				</tbody>
				</table>
				
				<a class="green_link_js" onclick="showLessDetailAboutOrder('order-<?php echo $i; ?>')">Meno dettagli 	&#9650;</a>
			</div>
			
		</div>
		<hr>
		
	<?php
			$i++;
		}
		
		if($i==0){
	?>
		<h2 class="title_no_orders">Non hai ancora effettuato ordini</h2>
		<img class="img_no_orders" src="./../../img/no-orders.png" alt="empty"></img>
	<?php } ?>
</body>
</html>