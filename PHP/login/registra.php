<?php

require("../config/config.php");
require("../api/base/fnQuery.php");

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
	$cel = $_POST["cel"];

	if ($dbh) {

		$params = [$mail];
		$sql = "SELECT Email
				FROM Utenti
				WHERE Email = ?";
		$query = query($dbh, $sql, $params);

		if ($query->status) {
			if ($query->rows && count($query->rows) > 0) {
				$response->response = "Nome utente già utilizzato";
			} else {

				$passHash = password_hash($pw, PASSWORD_DEFAULT);

				$params = [$mail, $passHash, $nome, $cognome, "", $cell, $nascita, 0];
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
					$response->response = "Registrazione effettuata con successo";
					$response->status = true;
				} else  {
					$response->response = $query->error;
				}
			}
		} else {
			$response->response = $query->error;
		}
	} else {
		$response->response = "Connessione database fallita";
	}
} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

$_SESSION["registrazione"] = $response;

if($response->status) {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
} else {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/registrati.php");
}

?>