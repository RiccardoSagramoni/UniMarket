<?php
	// Funzione che dato il codice abbreviato di una categoria, restituisce il nome completo.
	// Utilizzata per stampare il titolo della pagina /php/product.php
	function getTitleProductPage($category){
		switch($category){
			case 'frutta':
				return 'Frutta e verdura';
			case 'pasta':
				return 'Pane, pasta, riso e cereali';
			case 'carne':
				return 'Carne, salumi e uova';
			case 'pesce':
				return 'Pesce';
			case 'latte':
				return 'Latte e derivati';
			case 'veggie':
				return 'Alimenti vegetariani e vegani';
			case 'dolci':
				return 'Dolci, merendine e biscotti';
			case 'surgelati':
				return 'Surgelati e gelati';
			case 'mondobimbo':
				return "Alimenti per l'infanzia";
			case 'bibite':
				return 'Acqua e bibite analcoliche';
			case 'alcol':
				return 'Vino, birra e alcolici';
			case 'varie':
				return 'Varie e drogheria';
			default:
				return '404 NOT FOUND';
		}
	}
?>