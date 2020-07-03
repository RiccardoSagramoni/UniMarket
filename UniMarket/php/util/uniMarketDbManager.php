<?php
	// Questo file definisce le funzioni base per la corretta connessione con il server
	require_once __DIR__ . "/../../config.php";
	require_once DIR_BASE . "php/util/dbConfig.php";	//include la configurazione di accesso al db
	$uniMarketDb = new uniMarketDbManager();
	
	// Classe per gestire il database
	class uniMarketDbManager {
		private $mysqli_conn = null;
	
		function uniMarketDbManager(){
			$this->openConnection();
		}
    
    	function openConnection(){
    		if (!$this->isOpened()){
    			global $dbHostname;
    			global $dbUsername;
    			global $dbPassword;
    			global $dbName;
    			
    			$this->mysqli_conn = new mysqli($dbHostname, $dbUsername, $dbPassword);
				if ($this->mysqli_conn->connect_error) 
					die('Connect Error (' . $this->mysqli_conn->connect_errno . ') ' . $this->mysqli_conn->connect_error);

				$this->mysqli_conn->select_db($dbName) or
					die ('Can\'t use pweb: ' . mysqli_error());
			}
    	}
    
    	//Controlla se la connessione con il database e' aperta
    	function isOpened(){
       		return ($this->mysqli_conn != null);
    	}

   		// Esegue una query e restituisce il risultato
		function performQuery($queryText) {
			if (!$this->isOpened())
				$this->openConnection();
			
			return $this->mysqli_conn->query($queryText);
		}
		
		// Filtra il paramatro inserito come imput per evitare casi di sqlInjection
		function sqlInjectionFilter($parameter){
			if(!$this->isOpened())
				$this->openConnection();
				
			return $this->mysqli_conn->real_escape_string($parameter);
		}
		
		// Restituisce il numero dell'errore dell'ultima operazione effettuata
		function getErrorNumber(){
			if(!$this->isOpened())
				return null;
			
			return $this->mysqli_conn->errno;
		}
		
		// Restituisce il testp dell'errore dell'ultima operazione effettuata
		function getErrorText(){
			if(!$this->isOpened())
				return null;
			
			return $this->mysqli_conn->error;
		}
		
		// Chiude la connessione
		function closeConnection(){
 	       	if($this->mysqli_conn !== null)
				$this->mysqli_conn->close();
			
			$this->mysqli_conn = null;
		}
	}

?>