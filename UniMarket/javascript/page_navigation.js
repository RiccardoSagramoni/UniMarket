// 	Funzione di utilita' per ottenere la keyword cercata nello store
//	in modo da mantenere consistente la ricerca quando l'utente cambia pagina
function getNavigationPattern() {
	var pattern = document.getElementById("explore").value;
	return pattern;
}