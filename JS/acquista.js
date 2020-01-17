function apriTab(evento, nomeTab) {

  var i, contenutoTab, tablinks;

  //nascondo tutte le classi contenutoTab
  contenutoTab = document.getElementsByClassName("contenutoTab");
  for (i = 0; i < contenutoTab.length; i++) {
    contenutoTab[i].style.display = "none";
  }

  //disattivo le classi linkTab
  tablinks = document.getElementsByClassName("linkTab");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // mostro contenutoTab e attivo linkTab corrente
  document.getElementById(nomeTab).style.display = "block";
  evento.currentTarget.className += " active";
}
