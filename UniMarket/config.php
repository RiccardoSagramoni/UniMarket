<?php
	/* 	Definisce una variabile LOCAL_ROOT,
	 *	contenente l'indirizzo della root directory del progetto (relativamente al server locale).
	 *
	 *	File necessario per il corretto funzionamento dei link
	 *	implementati in php/layout/header.php , php/layout/sidebar.php
	 */
	$root = str_replace('/','\\',$_SERVER["DOCUMENT_ROOT"]);
	$base_directory = str_replace($root,$_SERVER['SERVER_NAME'],__DIR__);
	$base_directory = str_replace('\\','/',$base_directory);
	define("LOCAL_ROOT", $base_directory);
	
	
	/* 	Variabile DIR_BASE, contenente la directory della cartella root del progetto:
	 *	utilizzata negli statement include/require
	 */
	define("DIR_BASE", __DIR__ . "\\");

?>