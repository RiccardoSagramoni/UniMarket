// Riporta la visuale all'inizio della guida, considerando la presenza dello header che puo' nascondere parte del testo
function scrollUpToIndex(){
	location.hash = "#guida-iscrizione";
	scrollBy(0,-90);
}