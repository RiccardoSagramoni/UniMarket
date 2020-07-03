function showMoreDetailAboutOrder(item_id){
	var item = document.getElementById(item_id);
	item.getElementsByClassName("more_detail")[1].style.display = "block";
	
	item.getElementsByClassName("more_detail")[0].style.display = "none";
}

function showLessDetailAboutOrder(item_id){
	var item = document.getElementById(item_id);
	item.getElementsByClassName("more_detail")[0].style.display = "block";
	
	item.getElementsByClassName("more_detail")[1].style.display = "none";
}