<?php
	require_once "../PHP/modulesInit.php";
	require_once "../PHP/sqlInteractions.php";

	if(!isset($_SESSION))
		session_start();
		
	if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) {
		$output = file_get_contents("../HTML/nuovoEvento.html");
		$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
		$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Pannello Amministratore >> Inserimento Nuovo Evento"),$output);
		$nuovoEvento = "";
 
		#controllo se i campi obbligatori sono stati inseriti e se sono validi
			   if(isset($_POST['nome'])){
				   if(isset($_POST['prezzo'])){
					   if(modulesInit::validName($_POST['nome'])){
						   $valid = true;
						   if(isset($_POST['data'])){
							   if(modulesInit::validDate($_POST['data'])){
								   $valid = true;
							   }
							   else{
								   $valid = false;
							   }
						   }
						   if(isset($_POST['descrizioneEvento']) && $valid==true){
							   if(modulesInit::validDescription($_POST['descrizioneEvento'])){
								   $valid = true;
							   }
							   else{
								   $valid = false;
							   }
						   }
						   if($valid==true){
							   $oggettoPagina = new sqlInteractions();
							   $connessione = $oggettoPagina->apriConnessioneDB();
							   if($connessione){
								   $inserimento = $oggettoPagina->insertEvent();
								   if($inserimento){
									   $nuovoAnimale = "Inserimento nuovo evento avvenuto con successo.";
								   }
								   else{
									   $nuovoAnimale = "Inserimento nuovo evento non avvenuto per un problema del database.";
								   }
							   }
							   else{
								   $nuovoAnimale = "Connessione al database degli eventi fallita. Non &egrave; possibile procedere con l&apos;inserimento, riprova pi&ugrave; tardi.";
							   }
						   }
						   else{
							   $nuovoAnimale = "Le informazioni inserite non sono valide. Riprova.<br />Ricorda che i nomi possono contentere solo lettere e spazi.";
						   }
					   }
					   else{
						   $nuovoAnimale = "Il nome e/o il prezzo inseriti non sono validi. Riprova.";
					   }
				   }
				   else{
					   $nuovoAnimale = "Non &egrave; possibile procedere all&apos;inserimento del nuovo evento perch&egrave; non sono presenti tutti i cambi obbligatori.<br />Verifica di averli inseriti e riprova.";
				   }
			   }
			   $output = str_replace("<inserimentoNuovoEvento></inserimentoNuovoEvento>","<p class\"messaggio\">".$nuovoEvento."</p>",$output);
			   echo $output;
		   }
	   
#se il login non è stato effettuato
	else{
		$response = (Object) [
			"status" => -1
			,"response" => "Attenzione: non hai effettuato l&apos;accesso. Verrai reindirizzato alla pagina di login."
		];
		$_SESSION["logged"] = $response;

		echo modulesInit::setMessaggio($response->response, true);


	header("refresh:5; url= http://localhost/<progettoTecnologieWeb2019-2020/PAGES/login.php");
}

?>
