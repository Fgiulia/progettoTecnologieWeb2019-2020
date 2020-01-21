<?php
require("config/config.php");
require("api/fnQuery.php");

require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";

$nuovoEvento = null;

try {
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
					else {
						$valid = false;
					}
				}
				if($valid==true){
					$oggettoPagina = new sqlInteractions();
					$connessione = $oggettoPagina->apriConnessioneDB();
					if($connessione){
						$evento = (Object) [
							"nome" => $_POST['nome']
							,"prezzo" => $_POST['prezzo']
							,"data" => $_POST['data']
							,"descr" => $_POST['descrizioneEvento']
						];

						$inserimento = $oggettoPagina->insertEvent($evento);
						if($inserimento){
							$nuovoEvento = "Inserimento nuovo evento avvenuto con successo.";
						}
						else{
							$nuovoEvento = "Inserimento nuovo evento non avvenuto per un problema del database.";
						}
					}
					else{
						$nuovoEvento = "Connessione al database degli eventi fallita. Non &egrave; possibile procedere con l&apos;inserimento, riprova pi&ugrave; tardi.";
					}
				}
				else{
					$nuovoEvento = "Le informazioni inserite non sono valide. Riprova.<br />Ricorda che i nomi possono contentere solo lettere e spazi.";
				}
			}
			else{
				$nuovoEvento = "Il nome e/o il prezzo inseriti non sono validi. Riprova.";
			}
		}
		else{
			$nuovoEvento = "Non &egrave; possibile procedere all&apos;inserimento del nuovo evento perch&egrave; non sono presenti tutti i cambi obbligatori.<br />Verifica di averli inseriti e riprova.";
		}
	}
	$_SESSION["nuovoEvento"] = $nuovoEvento;
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/nuovoEvento.php");
} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

?>
