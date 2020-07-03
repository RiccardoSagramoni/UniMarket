<?php
	// File che contiene la struttura HTML dello header comune del sito
	require_once __DIR__ . "./../../config.php";
	require_once DIR_BASE . "/php/util/sessionUtil.php";
?>
<header>
	<?php
		echo '<a href="//'.LOCAL_ROOT.'/index.php" id="home_logo"><div id="logo"></div></a>';
		echo '<a id="titleUniMarket" href="//'.LOCAL_ROOT.'/index.php"><h1>UniMarket</h1></a>';
	?>
	<div class="flex_empty"></div>
	
	<?php 
		if(!isset($_SESSION))
			session_start();
		
		// Se non ha effettuato il login, mostra i link per il Login e la Registrazione
		if(!isLogged()){
	?>
		<div id="login" class="header_button">
			<a href="//<?php echo LOCAL_ROOT; ?>/php/login.php">Login</a>
		</div>
		<div id="registrati" class="header_button">
			<a href="//<?php echo LOCAL_ROOT; ?>/php/signUp.php">Registrati</a>
		</div>
	<?php
		}
		// altrimenti mostra i link per il profilo, gli ordini passati, il carrello ed eventualmente la sezione Admin
		else{
	?>
		<div id="profilo" class="header_button dropdown_container">
			<p class="dropdown_title"> Ciao, <?php echo $_SESSION['nomeUtente']; ?> </p>
			<a class="dropdown_content" href="//<?php echo LOCAL_ROOT; ?>/php/user/profilo.php">
				Il mio profilo
			</a>
			<a class="dropdown_content" href="//<?php echo LOCAL_ROOT; ?>/php/user/ordini.php">
				I miei ordini
			</a>
		</div>
		
		
		<?php if(isAdmin()){ ?>
		
			<div id="admin" class="header_button">
				<a href="//<?php echo LOCAL_ROOT; ?>/php/admin/admin.php">SEZIONE ADMIN</a>
			</div>
		
		<?php } ?>
		
		
		<div id="logout" class="header_button">
			<a href="//<?php echo LOCAL_ROOT; ?>/php/logout.php">Logout</a>
		</div>
	<?php 	} 
	?>
	
	<div id="carrello" class="header_button">
		<a href="//<?php echo LOCAL_ROOT; ?>/php/carrello.php">
			<div id="icona_carrello">
				<span id="numero_carrello">
				<?php
					if (isset($_SESSION["uniMarketuserId"])){
						// inizializa il contenuto del carrello
						$thisCarrello = getCurrentShoppingCart($_SESSION["uniMarketuserId"]);
						$itemsTaken = countItemTaken($thisCarrello);
						echo $itemsTaken->fetch_assoc()["howMany"];
					}
				?>
				</span>
			</div>
		</a>
	</div>
	
</header>