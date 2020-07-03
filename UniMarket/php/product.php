<?php
	// PAGINA Categoria di prodotti
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
	
	$category = $_GET["c"];
?>
<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta charset="utf-8"> 
	<meta name = "author" content = "Riccardo Sagramoni">
	<meta name = "keywords" content = "Supermercato, market, spesa online, spesa, pisa">
	<meta name = "description" content = "UniMarket: la spesa a casa vostra">
	<link rel="icon" type="image/png" href="./../img/favicon.png">
	<title><?php echo getTitleProductPage($category); ?> | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./../css/UniMarket.css" media="screen">
	<script src="./../javascript/sidebar.js"></script>
	<script src="./../javascript/ajax/ajaxManager.js"></script>
	<script src="./../javascript/ajax/itemLoader.js"></script>
	<script src="./../javascript/ajax/itemDashboard.js"></script>
	<script src="./../javascript/ajax/shoppingCart.js"></script>
	<script src="./../javascript/page_navigation.js"></script>
	<script src="./../javascript/product.js"></script>
</head>

<body>
	<?php
		include "./layout/header.php";
		include "./layout/sidebar.php";
	?>
	<script>
		selectPageMenu("<?php echo $category?>");
	</script>
	
	<div id="content">
		<div id="explore-wrapper">
			<input id="explore" type="text" placeholder="Cerca prodotto..." onkeyup="ItemLoader.search('<?php echo $category ?>', this.value)">
		</div>
		
		<?php
			include "./layout/page_navigation.php";
		?>
		
		<!-- Fill dinamically with Ajax Request -->
		<div id="itemDashboard" class="item_dashboard"></div>
		
		<?php
			include "./layout/page_navigation.php";
		?>
		
		<script>
			// Inizializza la pagina
			ItemLoader.search('<?php echo $category ?>', '');
		</script>
	</div>
</body>
</html>