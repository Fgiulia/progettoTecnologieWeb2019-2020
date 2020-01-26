<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";

$nuovoAnimale = "";

try {
	if(!isset($_SESSION))
		session_start();

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
	if(isset($_POST['nomeComune'])){
		if(isset($_POST['nomeComune']) && isset($_POST['nomeScientifico']) && isset($_POST['famiglia']) && isset($_POST['sezioneParco']) && isset($_FILES["immagineAnimale"]["tmp_name"]) && isset($_POST['descrizioneImmagine']) && isset($_POST['descrizioneAnimale'])){
			$valid = true;

			if($valid==true){
				if(modulesInit::validName($_POST['nomeComune'])){
					$valid = true;
				}
				else{
					$valid =false;
					$nuovoAnimale .= "Il nome comune inserito non &egrave; valido. Ricorda che pu&ograve; contentere solo lettere e spazi.<br />";
				}
			}

			if($valid==true){
				if(isset($_POST['nomeProprio']) && modulesInit::validNameP($_POST['nomeProprio'])){
					$valid = true;
				}
				else{
					$nuovoAnimale .= "Il nome proprio inserito non &egrave; valido. Ricorda che pu&ograve; contentere solo lettere e spazi.<br />";
					$valid = false;
				}
			}
			
			if($valid==true){
				if(modulesInit::validName($_POST['nomeScientifico'])){
					$valid = true;
				}
				else{
					$nuovoAnimale .= "Il nome scientifico inserito non &egrave; valido. Ricorda che pu&ograve; contentere solo lettere e spazi.<br />";
					$valid = false;
				}
			}

			if($valid==true){
				if(modulesInit::validImage($_FILES["immagineAnimale"]["tmp_name"])){
						$valid = true;
				}
				else{
					$nuovoAnimale .= "L&apos;immagine inserita non &egrave; valida.<br />";
					$valid = false;
				}
			}

			if($valid==true){
				if(modulesInit::validName($_POST['descrizioneImmagine'])){
					$valid = true;
				}
				else{
					$nuovoAnimale .= "La descrizione dell&apos;immagine inserita non &egrave; valida. Ricorda che pu&ograve; contentere solo lettere e spazi.<br />";
					$valid = false;
				}
			}

			if($valid==true){
				if(modulesInit::validDescription($_POST['descrizioneAnimale'])){
					$valid = true;
				}
				else{
					$nuovoAnimale .= "La descrizione dell&apos;animale inserita non &egrave; valida. Ricorda che pu&ograve; contentere solo 1200 caratteri.<br />";
					$valid = false;
				}
			}

			if($valid==true){
				$oggettoPagina = new sqlInteractions();
				$connessione = $oggettoPagina->apriConnessioneDB();

				if($connessione){
					$inserimento = $oggettoPagina->insertAnimal();

					if($inserimento){
						$nuovoAnimale .= "Inserimento nuovo animale avvenuto con successo.";
						unset($_POST['nomeComune']);
						unset($_POST['nomeProprio']);
						unset($_POST['nomeScientifico']);
						unset($_POST['famiglia']);
						unset($_POST['sezioneParco']);
						unset($_FILES["immagineAnimale"]["tmp_name"]);
						unset($_POST['descrizioneImmagine']);
						unset($_POST['descrizioneAnimale']);
					}
					else{
						$nuovoAnimale .= "Inserimento nuovo animale non avvenuto per un problema del database.";
					}
				}
				else{
					$nuovoAnimale .= "Connessione al database degli animali fallita. Non &egrave; possibile procedere con l&apos;inserimento, riprova pi&ugrave; tardi.";
				}
			}
		}
		else{
			$nuovoAnimale = "Non &egrave; possibile procedere all&apos;inserimento del nuovo animale perch&egrave; non sono presenti tutti i cambi obbligatori.<br />Verifica di averli inseriti e riprova.";
		}
	}

	$_SESSION["nuovoAnimale"] = $nuovoAnimale;

	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/nuovoAnimale.php");

} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

?>
