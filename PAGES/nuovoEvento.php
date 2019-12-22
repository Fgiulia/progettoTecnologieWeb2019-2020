<?php
require_once "../PHP/modulesInit.php";

if(!isset($_SESSION))
	session_start();
	
if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) {
    $output = file_get_contents("../HTML/nuovoEvento.html");
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Pannello amministratore > Eventi"),$output);
    
    echo $output;
}  else {
	$response = (Object) [
		"status" => -1
		,"response" => "Attenzione: non hai effettuato il login. Verrai reindirizzato alla pagina di login."
	];
	$_SESSION["logged"] = $response;

	echo modulesInit::setMessaggio($response->response, true);

    //header("refresh:3; url= http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
}
?>
