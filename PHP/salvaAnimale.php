<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";

$nuovoAnimale = null;

try {
	
	if(!isset($_SESSION))
		session_start();

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
	if(isset($_POST['nomeComune'])){
		if(isset($_POST['nomeScientifico']) && isset($_POST['famiglia'])){
			if(modulesInit::validName($_POST['nomeComune']) && modulesInit::validName($_POST['nomeScientifico'])){
				$valid = true;
				if(isset($_POST['nomeProprio'])){
					if(modulesInit::validName($_POST['nomeProprio'])){
						$valid = true;
					}
					else{
						$valid = false;
					}
				}
				if(isset($_POST['descrizioneImmagine']) && $valid==true){
					if(modulesInit::validName($_POST['descrizioneImmagine'])){
						$valid = true;
					}
					else{
						$valid = false;
					}
				}
				if(isset($_POST['descrizioneAnimale']) && $valid==true){
					if(modulesInit::validDescription($_POST['descrizioneAnimale'])){
						$valid = true;
					}
					else{
						$valid = false;
					}
				}
				if(isset($_FILES["immagineAnimale"]["tmp_name"]) && $valid==true){
					if(modulesInit::validImage($_FILES["immagineAnimale"]["tmp_name"])){
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
						$inserimento = $oggettoPagina->insertAnimal();
						if($inserimento){
							$nuovoAnimale = "Inserimento nuovo animale avvenuto con successo.";
						}
						else{
							$nuovoAnimale = "Inserimento nuovo animale non avvenuto per un problema del database.";
						}
					}
					else{
						$nuovoAnimale = "Connessione al database degli animali fallita. Non &egrave; possibile procedere con l&apos;inserimento, riprova pi&ugrave; tardi.";
					}
				}
				else{
					$nuovoAnimale = "Le informazioni inserite non sono valide. Riprova.<br />Ricorda che i nomi possono contentere solo lettere e spazi.";
				}
			}
			else{
				$nuovoAnimale = "Il nome comune e/o il nome scientifico inseriti non sono validi. Riprova.<br />Ricorda che possono contentere solo lettere e spazi.";
			}
		}
		else{
			$nuovoAnimale = "Non &egrave; possibile procedere all&apos;inserimento del nuovo animale perch&egrave; non sono presenti tutti i cambi obbligatori. Verifica di averli inseriti e riprova.";
		}
	}
	$_SESSION["nuovoAnimale"] = $nuovoAnimale;
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/nuovoEvento.php");
} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

?>
