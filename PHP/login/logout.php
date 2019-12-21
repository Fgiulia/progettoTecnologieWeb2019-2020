<?php

require_once "../modulesInit.php";

$response = (Object) [
	"status" => false
	,"response" => ""
];

try {

	unset($_SESSION["logged"]);
	
	$response->response = "Logout effettuato con successo. A breve verrai reindirizzato alla Homepage.";
	$response->status = true;

} catch (Exception $e) {
	$response->response = "Errore, ".$e->getMessage()."Riprova ad effettuare il logout, se il problema presiste contatta l'amministratore";
}


echo modulesInit::setMessaggio($response->response, $response->status);

if($response->status) {
	header("refresh:5: url:http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/home.php");
}

?>