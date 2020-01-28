<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";
require_once "../PHP/config/config.php";

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
					$nuovoAnimale .= "<p class=\"errorMessage\">Il nome comune inserito non &egrave; valido. Ricorda che pu&ograve; contentere solo lettere e spazi.</p>";
				}
			}

			if($valid==true){
				if(isset($_POST['nomeProprio']) && modulesInit::validNameP($_POST['nomeProprio'])){
					$valid = true;
				}
				else{
					$nuovoAnimale .= "<p class=\"errorMessage\">Il nome proprio inserito non &egrave; valido. Ricorda che pu&ograve; contentere solo lettere e spazi.</p>";
					$valid = false;
				}
			}
			
			if($valid==true){
				if(modulesInit::validName($_POST['nomeScientifico'])){
					$valid = true;
				}
				else{
					$nuovoAnimale .= "<p class=\"errorMessage\">Il nome scientifico inserito non &egrave; valido. Ricorda che pu&ograve; contentere solo lettere e spazi.</p>";
					$valid = false;
				}
			}

			if($valid==true){
				if(modulesInit::validImage($_FILES["immagineAnimale"]["tmp_name"])){
						$valid = true;
				}
				else{
					$nuovoAnimale .= "<p class=\"errorMessage\">L&apos;immagine inserita non &egrave; valida.</p>";
					$valid = false;
				}
			}

			if($valid==true){
				if(modulesInit::validName($_POST['descrizioneImmagine'])){
					$valid = true;
				}
				else{
					$nuovoAnimale .= "<p class=\"errorMessage\">La descrizione dell&apos;immagine inserita non &egrave; valida. Ricorda che pu&ograve; contentere solo lettere e spazi.</p>";
					$valid = false;
				}
			}

			if($valid==true){
				if(modulesInit::validDescription($_POST['descrizioneAnimale'])){
					$valid = true;
				}
				else{
					$nuovoAnimale .= "<p class=\"errorMessage\">La descrizione dell&apos;animale inserita non &egrave; valida. Ricorda che pu&ograve; contentere solo 1000 caratteri.</p>";
					$valid = false;
				}
			}

			if($valid==true){
				$oggettoPagina = new sqlInteractions();
				$connessione = $oggettoPagina->apriConnessioneDB();

				if($connessione){
					$inserimento = $oggettoPagina->insertAnimal();

					if($inserimento){
						$nuovoAnimale .= "<p class=\"successMessage\">Inserimento nuovo animale avvenuto con successo.</p>";
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
						$nuovoAnimale .= "<p class=\"errorMessage\">Inserimento nuovo animale non avvenuto per un problema del database.</p>";
					}
				}
				else{
					$nuovoAnimale .= "<p class=\"errorMessage\">Connessione al database degli animali fallita. Non &egrave; possibile procedere con l&apos;inserimento, riprova pi&ugrave; tardi.</p>";
				}
			}
		}
		else{
			$nuovoAnimale = "<p class=\"errorMessage\">Non &egrave; possibile procedere all&apos;inserimento del nuovo animale perch&egrave; non sono presenti tutti i cambi obbligatori, verifica di averli inseriti e riprova.</p>";
		}
	}

	$_SESSION["nuovoAnimale"] = $nuovoAnimale;

	header("Location: $url/PAGES/nuovoAnimale.php");

} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

?>
