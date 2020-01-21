<?php

$response = (Object) [
	"status" => false
	,"response" => ""
];

try {

	if(!isset($_SESSION))
		session_start();

	unset($_SESSION["logged"]);
	
	$response->response = "Logout effettuato con successo";
	$response->status = true;

} catch (Exception $e) {
	$response->response = "Errore&comma; ".$e->getMessage()."Riprova ad effettuare il logout&comma; se il problema presiste contatta l&apos;amministratore";
}

$_SESSION["messagge"] = $response->response;
header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/paginaVuota.php"); 

?>