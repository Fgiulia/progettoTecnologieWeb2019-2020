<?php

require("../PHP/config/config.php");
require("../PHP/api/beansMaps.php");
require("../PHP/api/fnQuery.php");
require("../PHP/api/fnFind.php");

require_once "../PHP/modulesInit.php";

if(!isset($_SESSION))
	session_start();
	
if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) {

	$output = file_get_contents("../HTML/areaPrivata.html");
	$output = str_replace('<a href="areaPrivata.php">','</a>',$output);
	$output = str_replace("<menu></menu>",modulesInit::menu(),$output);

	$contentItems = "";
	$sideNav = "";
	$breadcrumb = "";

	if($_SESSION["admin"] == 1) {

		$sideNav = "<div id='nav'>"."\n"
					."	<h3>Pannello gestione</h3>"."\n"
					."	<ul>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=principale'>Area privata</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=eventi'>Eventi</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=animali'>Animali</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=acquisti'>Acquisti</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=messaggi'>Messaggi</a></li>"."\n"
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
					."	<h3>Pannello gestione</h3>"."\n"
					."	<ul>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=principale'>Area privata</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=biglietti'>Biglietti acquistati</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=prenotazioni'>Eventi prenotati</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=messaggi'>Messaggi</a></li>"."\n"
					."	   <li><a href='datiPersonali.php'>Dati personali</a></li>"."\n"
					."	</ul>"."\n"
					."</div>"."\n";
	}

	$output = str_replace("<sideNav></sideNav>",$sideNav, $output);
	
	if(isset($_GET["pageName"])) {

		$pageName = $_GET["pageName"];
		
		$query = null;

		switch($pageName) {
			case "principale":
				$contentItems = "<div id='content'>"."\n"
								."	<h1 class='titolo'>Area privata</h1>"."\n"
								."	<h3>Azioni rapide</h3>"."\n"
								."	<div id='container'>"."\n"
								."		<a class='azioniRapide' href=''>boh</a>"."\n"
								."		<a class='azioniRapide' href=''>boh</a>"."\n"
								."	</div>"."\n"
								."</div>"."\n";
				$breadcrumb = "";
				break;
			case "eventi":
				$query = find("EventoBean", null);
				$breadcrumb = " -> Gestione eventi";
				break;
			case "animali":
				$query = find("AnimaleBean", null);
				$breadcrumb = " -> Gestione animali";
				break;
			case "acquisti":
				$breadcrumb = " -> Gestione acquisti";
				break;
			case "biglietti":
				$contentItems = "<div id='content'>"."\n".modulesInit::bigliettiAcquistati()."\n"."</div>"."\n";
				$breadcrumb = " -> Biglietti acquistati";
				break;
			case "prenotazioni":
				$breadcrumb = " -> Eventi prenotati";
				break;
			case "messaggi":
				//$query = find("MessaggioBean", null);
				$breadcrumb = " -> Messaggi";
				break;
		}
	}

	$output = str_replace("<contentItems></contentItems>",$contentItems, $output);
	$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Area Personale$breadcrumb"),$output);

	echo $output;
} else {
	$response = (Object) [
		"status" => -1
		,"response" => "Attenzione: non hai effettuato il login. Verrai reindirizzato alla pagina di login."
	];
	$_SESSION["logged"] = $response;

	echo modulesInit::setMessaggio($response->response, true);

	header("refresh:3; url= http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
}

?>