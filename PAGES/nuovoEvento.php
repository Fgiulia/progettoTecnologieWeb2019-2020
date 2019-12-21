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
		"status" => 1
		,"response" => "Non hai effettuato il login."
	];
	$_SESSION["logged"] = $response;
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
}
?>
