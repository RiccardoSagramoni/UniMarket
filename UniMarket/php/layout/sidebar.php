<?php
	// File che genera il sidebar del sito con le categorie di prodotti del catalogo
	require_once __DIR__ . "./../../config.php";
?>

<div id="menu_sidebar">
	<a class="menu_sidebar_icon">&#9776;  MENU</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=frutta' ?>" id ="frutta" class="menu_sidebar_link">FRUTTA E VERDURA</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=pasta' ?>" id="pasta" class="menu_sidebar_link">PANE, PASTA, RISO E CEREALI</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=carne' ?>" id="carne" class="menu_sidebar_link">CARNE, SALUMI  E UOVA</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=pesce' ?>" id="pesce" class="menu_sidebar_link">PESCE</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=latte' ?>" id="latte" class="menu_sidebar_link">LATTE E DERIVATI</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=veggie' ?>" id="veggie" class="menu_sidebar_link">ALIMENTI VEGETARIANI E VEGANI</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=dolci' ?>" id="dolci" class="menu_sidebar_link">DOLCI, MERENDINE E BISCOTTI</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=surgelati' ?>" id="surgelati" class="menu_sidebar_link">SURGELATI E GELATI</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=mondobimbo' ?>" id="mondobimbo" class="menu_sidebar_link">ALIMENTI PER L'INFANZIA</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=bibite' ?>" id="bibite" class="menu_sidebar_link">ACQUA E BIBITE ANALCOLICHE</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=alcol' ?>" id="alcol" class="menu_sidebar_link">VINO, BIRRA E ALCOLICI</a>
	<a href="//<?php echo LOCAL_ROOT.'/php/product.php?c=varie' ?>" id="varie" class="menu_sidebar_link">VARIE E DROGHERIA</a>
</div>