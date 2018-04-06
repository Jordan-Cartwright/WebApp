// Add custom javascript here



var btns = document.querySelectorAll(".btn-delete");
for (var i = 0; i < btns.length; i++) {
	btns[i].addEventListener("click",ajaxDelete2);
}



function ajaxDelete2() {
	var id = this.id;
	//alert(id);
	id = id.substring(1);
	//alert(id);
	var request = new XMLHttpRequest();
	request.addEventListener("load", removeQuestion2);
	request.open("POST", "delete_user_json.php", true);
	request.setRequestHeader("Content-Type", "application/json");
	request.send(id);
}



function removeQuestion2() {
	var id = this.response;
	//alert(id);
	var btn = document.querySelector("#"+id);
	var card = btn.parentNode.parentNode;
	card.parentNode.removeChild(card);
}