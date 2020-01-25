<?php
	require_once "../PHP/modulesInit.php";
	require_once "../PHP/sqlInteractions.php";

	if(!isset($_SESSION))
		session_start();
		
	if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2 && $_SESSION["admin"] == 1) {
		$output = file_get_contents("../HTML/nuovoEvento.html");
		$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
		$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Pannello Amministratore >> Inserimento Nuovo Evento"),$output);
	
		if(isset($_SESSION["nuovoEvento"])) {
			$output = str_replace("<inserimentonuovoevento></inserimentonuovoevento>","<p class\"messaggio\">".$_SESSION["nuovoEvento"]."</p>",$output);
		}
		echo $output;
	}
	#se il login non è stato effettuato
	else {
		$response = (Object) [
            "status" => -1
            ,"response" => "" 
        ];

        if($_SESSION["admin"] == 0) {
            $response->response = "Attenzione: non hai i permessi necessari per accedere alla pagina, verrai reindirizzato alla home.";
            $_SESSION["logged"] = $response;
            echo modulesInit::setMessaggio($response->response, true);
    
            header("refresh:5; url= http://localhost:/progettoTecnologieWeb2019-2020/PAGES/home.php");
        } else {
            $response->response = "Attenzione: non hai effettuato il login, verrai reindirizzato alla pagina di login.";
            $_SESSION["logged"] = $response;
            echo modulesInit::setMessaggio($response->response, true);
    
            header("refresh:5; url= http://localhost/progettoTecnologieWeb2019-2020/PAGES/login.php");
        }
	}
?>
