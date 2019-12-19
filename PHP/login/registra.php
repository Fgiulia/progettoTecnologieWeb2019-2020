<?php

require("../../config/config.php");
require("../base/fnQuery.php");
require("../session_recovery.php");

require("../lib/PHPMailer-6.0.1/src/Exception.php");
require("../lib/PHPMailer-6.0.1/src/PHPMailer.php");
require("../lib/PHPMailer-6.0.1/src/SMTP.php");

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
				$params = [$mail, $pw, $nome, $cognome, "", $cell, $nascita, 0];
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

if($response->status) {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
} else {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/registra.php");
}

?>