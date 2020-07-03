/*	OGGETTO SLIDESHOW
 *	Implementa su un oggetto dato (obj) le funzioni di gestione delle transizioni delle immagini/slide
 */
function slideShow(obj, tm){
	this.container = obj
	this.slideIndex = 0
	this.clockEvent = null
	this.period = tm
	
	this.moveSlide = function(spostamento){
		this.showSlide(this.slideIndex += spostamento);
		this.goClock();
	}
	
	// nasconde tutte le slide, eccetto quella al momento selezionata
	this.showSlide = function(newPosition){
		var slideElement = this.container.getElementsByClassName("mySlide");
		
		if (newPosition >= slideElement.length) {
			this.slideIndex = 0;
		}
		else if (newPosition < 0) {
			this.slideIndex = slideElement.length - 1;
		}
		
		for (var i = 0; i < slideElement.length; i++) {
			slideElement[i].style.display = "none";
		}
		slideElement[this.slideIndex].style.display = "block";
	}
	
	this.goClock = function(){
		if(this.clockEvent != null){
			clearTimeout(this.clockEvent);
		}
		
		this.clockEvent = setTimeout("slider.moveSlide(1)",this.period);
	}
}