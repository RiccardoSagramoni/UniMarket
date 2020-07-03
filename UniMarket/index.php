<?php
	// HOME PAGE DEL SITO, comprensiva della guida per l'utente
	session_start();
	require_once "./config.php";
	require_once DIR_BASE . "php\util\uniMarketDbManager.php";
    require_once DIR_BASE . "php\util\sessionUtil.php";
	require_once DIR_BASE . "php\util\databaseFunctionManagement.php";
?>
<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta charset="utf-8"> 
	<meta name = "author" content = "Riccardo Sagramoni">
	<meta name = "keywords" content = "Supermercato, market, spesa online, spesa, pisa">
	<meta name = "description" content = "UniMarket: la spesa a casa vostra">
	<link rel="icon" type="image/png" href="./img/favicon.png">
	<title>Homepage | UniMarket</title>
	<link rel="stylesheet" type="text/css" href="./css/UniMarket.css" media="screen">
	<script src="./javascript/slideShow.js"></script>
	<script src="./javascript/ajax/shoppingCart.js"></script>
</head>
<body>
	<?php
		include "./php/layout/header.php";
		include "./php/layout/sidebar.php";
	?>
	
	<div id="content">
		<!-- SLIDESHOW -->
		<div id="slide_content" class="slide-content">
		
			<script>
				var sliderContainer = document.getElementById("slide_content");
				var slider = new slideShow(sliderContainer, 5000);
			</script>
		
			<div class="mySlide">
				<img src="./img/slideImg1.jpg" alt="supermercato">
				<span class="mySlideText">
					<span>	<strong>UniMarket</strong>
							<br>Il tuo supermercato direttamente a casa tua
					</span>
				</span>
			</div>
			<div class="mySlide">
				<img src="./img/slideImg2.jpeg" alt="supermercato">
				<span class="mySlideText">
					<span>	Solo i migliori prodotti,
							<br>scelti appositamente per te
					</span>
				</span>
			</div>
			<div class="mySlide">
				<img src="./img/slideImg3.jpg" alt="supermercato">
				<span class="mySlideText">
					<span>	Paga comodamente online
							<br>con carta di credito o prepagata
					</span>
				</span>
			</div>
			
			<button class="slide-button slide-display-left" onclick="slider.moveSlide(-1)">&#10094;</button>
			<button class="slide-button slide-display-right" onclick="slider.moveSlide(+1)">&#10095;</button>
			
			<script>
				// inizia l'effetto di "rotazione" automatica dello slideshow
				slider.goClock();
			</script>
		</div>
		
		<script>
			function tornaAllIndiceDellaGuida(){
				location.hash = "#guida-iscrizione";
				scrollBy(0,-130);
			}
		</script>
		
		<!-- PRESENTAZIONE DEL SITO -->
		<div id="guida-iscrizione" class="presentazione_sito">
			<h2>Benvenuto nel supermercato online UNIMARKET</h2>
			<p>Se è la prima volta che accedi al nostro portale, in questa pagina è contenuta una breve
			guida all'utilizzo del supermercato.
			<br>Ti ricordiamo che potrai tornare su questa pagina in ogni momento cliccando sul logo o sulla scritta UNIMARKET in alto a sinistra</p>
			<ol>
				<li><a href=#guida-iscrizione-login>Iscrizione e Login</a></li>
				<li><a href=#guida-iscrizione-prodotto>Come cercare e acquistare un prodotto</a></li>
				<li><a href=#guida-iscrizione-carrello>Come controllare e concludere la spesa</a></li>
				<li><a href=#guida-iscrizione-recensione>Come recensire un prodotto</a></li>
				<li><a href=#guida-iscrizione-profilo>Come modificare i propri dati personali (email, password, indirizzo, numero di telefono)</a></li>
				<li><a href=#guida-iscrizione-ordini>Come vedere i vecchi ordini</a></li>
			</ol>
			
			<div id="guida-iscrizione-login">
				<h3>1. Iscrizione e Login</h3>
				<p><strong>Se non hai ancora un account</strong>, puoi cliccare sul pulsante "Registrati" presente
				nella barra in alto. Verrai indirizzato alla pagine di registrazione in cui ti verranno chiesti
				alcuni tuoi dati personali necessari al corretto funzionamento del servizio.</p>
				<p><strong>Se hai già un account</strong>, puoi cliccare sul pulsante "Login" in alto a destra ed
				accedere al sito utilizzando l'email e la password scelti in fase di registrazione.
				</p>
				<a onclick="tornaAllIndiceDellaGuida()">Torna su &uarr;</a>
			</div>
			
			<div id="guida-iscrizione-prodotto">
				<h3>2. Come cercare e acquistare un prodotto</h3>
				<p>Nella parte sinistra dello schermo è presente una sidebar contenente le varie categorie di
				prodotti del supermercato. Ogni categoria ha il proprio catalogo che è possibile sfogliare
				utilizzando le frecce direzionali o filtrare utilizzando l'apposita barra di ricerca.
				</p>
				<p><strong>Attenzione! </strong>La ricerca dei nostri prodotti non è "intelligente" come Google, ma 
				lavora per omonimia. Quindi se cercerai la parola "arancione" nella sezione Frutta difficilmente 
				troverai delle "arance", ma se inizierai a digitare "ARAN" sicuramente sì!
				</p>
				<br>
				<p>Per mettere il prodotto nel carrello, basta premere il pulsante azzurro a forma di carrello sotto il nome del prodotto. Altrimenti, cliccando sull'oggetto da acquistare, potrà accedere alla scheda del prodotto che contiene, oltre ad ulteriori informazioni utili e alle recensioni degli altri utenti, un pulsante arancione apposito, di fianco al prezzo.
				</p>
				<p>Prima di inserire il prodotto nel carrello, può selezionarne inoltre la quantità, utilizzando l'apposita casella che si trova accanto al prezzo dell'oggetto.
				</p>
				<a onclick="tornaAllIndiceDellaGuida()">Torna su &uarr;</a>
			</div>
			
			<div id="guida-iscrizione-carrello">
				<h3>3. Come controllare e concludere la spesa</h3>
				<p>Una volta che tutti i prodotti della tua spesa sono stati aggiunti nel carrello, per inviare
				l'ordine e permettere agli operatori di preparare la spedizione basta premere sull'icona in alto a 
				destra a forma di <strong>carrello</strong>. Si aprirà il portale del tuo attuale carrello, che puoi
				usare per controllare i prodotti che vi hai inseriti ed <em>eliminare i prodotti aggiunti per errore
				</em>. Sulla destra troverai anche il resoconto del carrello con il tasto INVIA, da utilizzare quando
				la spesa è conclusa per pagare e far partire la spedizione.
				</p>
				<a onclick="tornaAllIndiceDellaGuida()">Torna su &uarr;</a>
			</div>
			
			<div id="guida-iscrizione-recensione">
				<h3>4. Come recensire un prodotto</h3>
				<p>Per recensire un prodotto, basta andare nella pagina personale dell'oggetto in questione 
				(cliccandovi sopra nella pagina della Categoria). Lì potrai trovare un modulo apposito da compilare
				inserendo la votazione in stelle e un breve commento. E' inoltre possibile sia modificare una 
				recensione precedentemente scritta (clicca su MODIFICA, apporta le opportune modifiche e infine premi 
				CONFERMA per confermare o ANNULLA per annullare), sia eliminarla dal portale (cliccando prima su 
				MODIFICA e poi su ELIMINA).
				</p>
				<a onclick="tornaAllIndiceDellaGuida()">Torna su &uarr;</a>
			</div>
			
			<div id="guida-iscrizione-profilo">
				<h3>5. Come modificare i propri dati personali</h3>
				<p>Per modificare i dati del tuo profilo, posiziona il cursore sopra la scritta "<strong>Ciao
					<?php if(isset($_SESSION['nomeUtente'])) echo $_SESSION['nomeUtente']; else echo 'Mario'; ?></strong>" per aprire il menù a tendina del tuo profilo personale e seleziona l'opzione <strong>IL MIO PROFILO</strong>
				</p>				
				<a onclick="tornaAllIndiceDellaGuida()">Torna su &uarr;</a>
			</div>
			
			<div id="guida-iscrizione-ordini">
				<h3>6. Come vedere i vecchi ordini</h3>
				<p>Per visuonare i tuoi vecchi ordini, posiziona il cursore sopra la scritta "<strong>Ciao
					<?php if(isset($_SESSION['nomeUtente'])) echo $_SESSION['nomeUtente']; else echo 'Mario'; ?></strong>" per aprire il menù a tendina del tuo profilo personale e seleziona l'opzione <strong>I MIEI ORDINI</strong>
				</p>
				<p>Per copiare un vecchio ordine nel tuo attuale carrello accanto ad ogni ordine e' presente il pulsante arancione "Aggiungi al carrello" apposito per tale funzione.
				</p>
				<a onclick="tornaAllIndiceDellaGuida()">Torna su &uarr;</a>
			</div>
		</div>
	</div>
</body>
</html>






