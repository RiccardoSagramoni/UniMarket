<?php  
	/*
		AjaxResponse is the class that will be sent back to the client at every Ajax request.
		The class is serialize according the Json format through the json_encode function, that 
		serialize ONLY the public property.
	*/
	class AjaxResponse{
		public $responseCode; // 0 all ok - 1 some errors - -1 some warning
		public $message;
		public $data;
		
		function AjaxResponse($responseCode = 1, 
								$message = "Somenthing went wrong! Please try later.",
								$data = null){
			$this->responseCode = $responseCode;
			$this->message = $message;
			$this->data = null;
		}
	
	}

	class Item{
		public $itemID;
		public $nome;
		public $categoria;
		public $descrizione;
		public $origine;
		public $costo;
		public $disponibilita;
		public $rate;
		
		function Item($itemID = null, $nome = null, $categoria = null, $descrizione = null, 
						$origine = null, $costo = null, $disponibilita = null, $rate = null){
			$this->itemID = $itemID;
			$this->nome = $nome;
			$this->categoria = $categoria;
			$this->descrizione = $descrizione;
			$this->origine = $origine;
			$this->costo = $costo;
			$this->disponibilita = $disponibilita;
			$this->rate = $rate;
		}
	}

?>