<?php
require_once "../PHP/modulesInit.php";

if(!isset($_SESSION))
	session_start();
	
if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) {

	$output = file_get_contents("../HTML/areaPrivata.html");
	$output = str_replace('<a href="areaPrivata.php">','</a>',$output);
	$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
	$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Area Personale"),$output);

	if($_SESSION["admin"] == 1) {

		$sideNav = "<div id='nav'>"."\n"
					."	<h3>Pannello gestione</h3>"."\n"
					."	<ul>"."\n"
					."	   <li><a href='areaPrivata.php'>Area privata</a></li>"."\n"
					."	   <li><a href='gestioneEventi.php'>Eventi</a></li>"."\n"
					."	   <li><a href='gestioneAnimali.php'>Animali</a></li>"."\n"
					."	   <li><a href='gestioneAcquisti.php'>Acquisti</a></li>"."\n"
					."	   <li><a href='messaggi.php'>Messaggi</a></li>"."\n"
					."	   <li><a href='../PHP/login/logout.php'>Logout</a></li>"."\n"
					."	</ul>"."\n"
					."</div>"."\n";
		
		$contentItems = "<div id='content'>"."\n"
						."	<h1 class='titolo'>Area privata</h1>"."\n"
						."	<h3>Azioni rapide</h3>"."\n"
						."	<div id='container'>"."\n"
						."		<a class='azioniRapide' href='nuovoEvento.php'>Nuovo evento</a>"."\n"
						."		<a class='azioniRapide' href='nuovoAnimale.php'>Nuovo animale</a>"."\n"
						."	</div>"."\n"
						."</div>"."\n";

	} else {
		$sideNav = "<div id='nav'>"."\n"
					."	<ul>"."\n"
					."	   <li><a href='areaPrivata.php'>Area privata</a></li>"."\n"
					."	   <li><a href='bigliettiAquistati.php'>Eventi</a></li>"."\n"
					."	   <li><a href='eventiPrenotati.php'>Animale</a></li>"."\n"
					."	   <li><a href='messaggi.php'>Messaggi</a></li>"."\n"
					."	   <li><a href='datiPersonali.php'>Dati personali</a></li>"."\n"
					."	   <li><a href='../PHP/login/logout.php'>Logout</a></li>"."\n"
					."	</ul>"."\n"
					."</div>"."\n";
		
		$contentItems = "<div id='content'>"."\n"
						."	<h1 class='titolo'>Area privata</h1>"."\n"
						."	<h3>Azioni rapide</h3>"."\n"
						."	<div id='container'>"."\n"
						."		<a class='azioniRapide' href=''>boh</a>"."\n"
						."		<a class='azioniRapide' href=''>boh</a>"."\n"
						."	</div>"."\n"
						."</div>"."\n";
	}

	$output = str_replace("<sideNav></sideNav>",$sideNav, $output);
	$output = str_replace("<contentItems></contentItems>",$contentItems, $output);

	echo $output;
} else {
	$response = (Object) [
		"status" => 1
		,"response" => "Non hai effettuato il login."
	];
	$_SESSION["logged"] = $response;
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
}

?>