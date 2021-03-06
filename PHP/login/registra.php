<?php

require("../config/config.php");
require("../api/fnQuery.php");

require_once "../modulesInit.php";

$response = (Object) [
	"status" => false
	,"response" => "init"
];

try {

	$mail = $_POST["email"];
	$nome = $_POST["nome"];
	$cognome = $_POST["cognome"];
	$nascita = $_POST["nascita"];
	$pw = $_POST["password"];
	$pwRi = $_POST["ripetiPassword"];
	$cel = $_POST["numeroTelefono"];
	$indirizzo = $_POST["indirizzo"];

	if ($dbh) {

		$params = [$mail];
		$sql = "SELECT Email
				FROM Utenti
				WHERE Email = ?";
		$query = query($dbh, $sql, $params);

		if ($query->status) {
			if ($query->rows && count($query->rows) > 0) {
				$response->response = "Nome utente gi&agrave; utilizzato.";
			} else {
				if( modulesInit::validName($nome)
					&& modulesInit::validName($cognome)
					&& modulesInit::validEmail($mail)
					&& modulesInit::validPhone($cel)
					&& modulesInit::validPass($pw)
					&& modulesInit::validPass($pwRi)
					&& $pw === $pwRi ) {

					if(modulesInit::checkDateFormat($nascita)) {
						if(modulesInit::checkBirthdate($nascita)) {
							$passHash = password_hash($pw, PASSWORD_DEFAULT);

							$params = [$mail, $passHash, $nome, $cognome, $cel, $indirizzo, $nascita, 0];
							$sql = "INSERT INTO Utenti (
										Email
										,Password
										,Nome
										,Cognome
										,Telefono
										,Indirizzo
										,DataNascita
										,FlAdmin
									) VALUES (?,?,?,?,?,?,?,?)";
			
							$query = query($dbh, $sql, $params);
			
							if ($query->status) {
								$response->response = "Registrazione effettuata con successo. Puoi effettuare il login.";
								$response->status = true;
							} else  {
								$response->response = $query->error;
							}
						} else  {
							$response->response = "Non &egrave; possibile procedere alla registrazione perch&egrave; devi essere maggiorenne per registrarti.";
						}
					} else {
						$response->response = "Inserisci la data nel formato yyyy-mm-dd o dd-mm-yyyy, prestando attenzioni a usare i trattini";
					}
				} else {
					$response->response = "Non &egrave; possibile procedere alla registrazione perch&egrave; non sono presenti tutti i cambi obbligatori.<br />Verifica di averli inseriti e riprova.";
				}
			}
		} else {
			$response->response = $query->error;
		}
	} else {
		$response->response = "Connessione al database fallita.";
	}
} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

$_SESSION["registrazione"] = $response;

header("Location: $url/PAGES/registrati.php");


?>