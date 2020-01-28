<?php

require("../PHP/config/config.php");
require("../PHP/api/beansMaps.php");
require("../PHP/api/fnQuery.php");
require("../PHP/api/fnFind.php");

require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";

if(!isset($_SESSION))
	session_start();
	
if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) {

	$output = file_get_contents("../HTML/areaPrivata.html");
	$output = str_replace('<a href="areaPrivata.php">','</a>',$output);
	$output = str_replace("<menu></menu>",modulesInit::menu(),$output);

	$contentItems = "";
	$sideNav = "";
	$breadcrumb = "";

	$utente = $_SESSION["utente"];

	if($_SESSION["admin"] == 1) {

		$sideNav = "<div id='nav'>"."\n"
					."	<h3>Pannello Gestione</h3>"."\n"
					."	<ul>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=principale'>Area Amministratore</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=eventi'>Eventi</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=animali'>Animali</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=acquisti'>Acquisti</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=messaggi'>Messaggi</a></li>"."\n"
					."	</ul>"."\n"
					."</div>"."\n";
		
		$contentItems = "<div id='content'>"."\n"
						."	<h1 class='titolo'>Area Amministratore</h1>"."\n"
						."	<h3>Azioni Rapide</h3>"."\n"
						."	<p>Benvenuto $utente! Scegli cosa fare dalle azioni rapide o naviga con il menu a sinistra!</p>"."\n"
						."	<div id='container'>"."\n"
						."		<a class='azioniRapide' href='nuovoEvento.php'>Nuovo Evento</a>"."\n"
						."		<a class='azioniRapide' href='nuovoAnimale.php'>Nuovo Animale</a>"."\n"
						."	</div>"."\n"
						."</div>"."\n";

	} else {
		$sideNav = "<div id='nav'>"."\n"
					."	<h3>Pannello Gestione</h3>"."\n"
					."	<ul>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=principale'>Area Personale</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=biglietti'>Biglietti Acquistati</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=prenotazioni'>Eventi Prenotati</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=messaggi'>Messaggi</a></li>"."\n"
					."	   <li><a href='areaPrivata.php?pageName=datiPersonali'>Dati Personali</a></li>"."\n"
					."	</ul>"."\n"
					."</div>"."\n";

		$contentItems = "<div id='content'>"."\n"
					."	<h1 class='titolo'>Area Personale</h1>"."\n"
					."	<h3>Azioni rapide</h3>"."\n"
					."	<p>Benvenuto $utente! Scegli cosa fare dalle azioni rapide o naviga con il menu a sinistra!</p>"."\n"
					."	<div id='container'>"."\n"
					."		<a class='azioniRapide' href='areaPrivata.php?pageName=messaggi'>Messaggi</a>"."\n"
					."		<a class='azioniRapide' href='acquista.php'>Acquista Biglietti</a>"."\n"
					."		<a class='azioniRapide' href='info.php'>Contatta l'Amministratore</a>"."\n"
					."	</div>"."\n"
					."</div>"."\n";
	}

	$output = str_replace("<sideNav></sideNav>",$sideNav, $output);
	
	if(isset($_GET["pageName"])) {

		$pageName = $_GET["pageName"];
		
		$query = null;

		switch($pageName) {
			case "principale":
				$breadcrumb = "";
				break;
			case "eventi":
				$breadcrumb = " >> Gestione eventi";
				$contentItems = "<div id='content'>"."\n"
									."<p><b>Attenzione:</b> eliminando un evento, verranno eliminati anche gli acquisti degli utenti ad esso associati.</p>"."\n"
									.modulesInit::getEventi()
								."</div>"."\n";
				break;
			case "animali":
				$breadcrumb = " >> Gestione animali";
				$contentItems = "<div id='content'>"."\n"
								.modulesInit::getAnimali()
								."</div>"."\n";
				break;
			case "acquisti":
				$breadcrumb = " >> Gestione acquisti";
				
				$contentItems = "<div class='containerAcquisti'>"."\n"
								."	<div class='tabBar'>"."\n"
								."		<button class='barButton' onclick=\"openTab('biglietti')\">Biglietti</button>"."\n"
								."		<button class='barButton' onclick=\"openTab('eventi')\">Eventi</button>"."\n"
								."	</div>"."\n"
								."	<div id='biglietti' class='contentAcquisti'><h3>Biglietti</h3> "."\n".modulesInit::bigliettiAcquistati()."\n"."</div>"."\n"
								."	<div id='eventi' class='contentAcquisti'><h3>Eventi</h3>"."\n".modulesInit::eventiPrenotati()."\n"."</div>"."\n"
								."</div>"."\n";
				break;
			case "biglietti":
				$contentItems = "<div id='content'>"."\n".modulesInit::bigliettiAcquistati()."\n"."</div>"."\n";
				$breadcrumb = " >> Biglietti acquistati";
				break;
			case "prenotazioni":
				$contentItems = "<div id='content'>"."\n".modulesInit::eventiPrenotati()."\n"."</div>"."\n";
				$breadcrumb = " >> Eventi prenotati";
				break;
			case "messaggi":
				$contentItems = "<div id='content'>"."\n".modulesInit::getMessaggi()."\n"."</div>"."\n";
				$breadcrumb = " >> Messaggi";
				break;
			case "datiPersonali":
				$response = find("UtenteBean",(Object)['Email' => $_SESSION["user"]]);

				if($response->status) {

					$utente = $response->response[0];
					$data = date('d-m-Y', strtotime($utente->DataNascita));

					$contentItems ="<div id='content'>"."\n"
								."	<h2>I tuoi dati personali</h2>"."\n"
								."	<div>"."\n"
								."		<div>"."\n"
								."			<span>Nome:</span>"."\n"
								."			<span id='nome'>".$utente->Nome."</span>"."\n"
								."		</div>"."\n"
								."		<div>"."\n"
								."			<span>Cognome:</span>"."\n"
								."			<span id='cognome'>".$utente->Cognome."</span>"."\n"
								."		</div>"."\n"
								."		<div>"."\n"
								."			<span>Data di nascita:</span>"."\n"
								."			<span id='data'>".$data."</span>"."\n"
								."		</div>"."\n"
								."		<div>"."\n"
								."			<span>E-mail:</span>"."\n"
								."			<span id='email'>".$utente->Email."</span>"."\n"
								."		</div>"."\n"
								."		<div>"."\n"
								."			<span>Telefono:</span>"."\n"
								."			<span id='email'>".$utente->Telefono."</span>"."\n"
								."		</div>"."\n"
								."	</div>"."\n"
								."</div>"."\n";
				}
				
				$breadcrumb = " >> I tuoi dati";
				break;
			default:
				$breadcrumb = "";
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

	header("refresh:5; url= http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
}

?>