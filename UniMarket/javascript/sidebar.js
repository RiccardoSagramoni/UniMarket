//	Funzione di utilita' per selezionare all'interno del sidebar
//	la categoria di prodotti relativa alla pagina attuale (cambia il backgroundColor del link)
function selectPageMenu(page){
	var thisMenuPage = document.getElementById(page);
	thisMenuPage.style.backgroundColor = "blue";
}