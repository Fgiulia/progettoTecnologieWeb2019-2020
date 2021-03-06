<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";
require_once "../PHP/config/config.php";

$nuovoEvento = null;

try {
	
	if(!isset($_SESSION))
		session_start();

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
	if(!empty(['nome']) && !empty($_POST['prezzo'])){
		if(modulesInit::validName($_POST['nome']))
			$valid = true;
		else
			$valid = false;

		if (!empty($_POST['data']) && $valid == true){
			if (modulesInit::checkDateFormat($_POST['data']) && modulesInit::validDate($_POST['data'])){
				$valid = true;
			}
			else{
				$valid = false;
			}
		}
		else{
			$valid=false;
		}

		if (!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST['prezzo']) && $valid == true)
			$valid = false;

		if(($_POST['descrizioneEvento']))
			if (!modulesInit::validDescription($_POST['descrizioneEvento']) && $valid == true)
				$valid = false;
	
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
						$nuovoEvento = "<p class=\"successMessage\">Inserimento nuovo evento avvenuto con successo.</p>";
					}
					else{
						$nuovoEvento = "<p class=\"errorMessage\">Inserimento nuovo evento non avvenuto per un problema del database.</p>";
					}
				}
				else{
					$nuovoEvento = "<p class=\"errorMessage\">Connessione al database degli eventi fallita. Non &egrave; possibile procedere con l&apos;inserimento, riprova pi&ugrave; tardi.</p>";
				}
			}
			else{
				$nuovoEvento = "<p class=\"errorMessage\">Le informazioni inserite non sono valide. Ricorda che i nomi possono contentere solo lettere e spazi, che la data deve essere nel futuro e nel formato ANNO-MESE-GIORNO e che il prezzo accetta solo un numero con massimo due cifre decimali (separato dal punto).</p>";
			}
		}
		else{
			$nuovoEvento = "<p class=\"errorMessage\">Non &egrave; possibile procedere all&apos;inserimento del nuovo evento perch&egrave; non sono presenti tutti i cambi obbligatori.<br />Verifica di averli inseriti e riprova.</p>";
		}
	
	$_SESSION["nuovoEvento"] = $nuovoEvento;
	header("Location: $url/PAGES/nuovoEvento.php");
} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

?>
