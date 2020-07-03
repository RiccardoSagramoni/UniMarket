<?php
	// FILE DI GESTIONE DELLA SESSIONE
	
	//setSession: set $_SESSION properly
	function setSession($nome, $userId){
		$_SESSION['uniMarketuserId'] = $userId;
		$_SESSION['nomeUtente'] = $nome;
	}

	//isLogged: check if user has logged in and, if it is the case, returns the userID
	function isLogged(){		
		if(isset($_SESSION['uniMarketuserId']) && isset($_SESSION['nomeUtente']))
			return $_SESSION['uniMarketuserId'];
		else
			return false;
	}
	
	
	// Effettua l'accesso come admin
	function logAsAdmin(){
		$adminCode = 'R5WDjgSJKR3qRn';
		
		$_SESSION['admin'] = $adminCode;
	}
	
	// Controlla che l'utente sia un admin
	function isAdmin(){
		$adminCode = 'R5WDjgSJKR3qRn';
		
		if(isset($_SESSION['admin']) && $_SESSION['admin'] == $adminCode)
			return true;
		else
			return false;
	}
?>