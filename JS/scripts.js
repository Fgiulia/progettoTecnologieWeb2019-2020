function mobileMenu() {
	var x = document.getElementById("menu");
	if (x.className === "topnav") {
		x.className += " responsive";
	} else {
		x.className = "topnav";
	}
}

function openTab(tabName) {
	var i;
	var x = document.getElementsByClassName("contentAcquisti");
	for (i = 0; i < x.length; i++) {
		x[i].style.display = "none";
	}
	document.getElementById(tabName).style.display = "block";
}