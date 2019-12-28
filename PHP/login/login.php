<?php
require("../config/config.php");
require("../api/fnQuery.php");

$response = (Object) [
	"status" => 0
	,"response" => "init"
];

# Status:  0 -> login fallito, 1 -> altri errori, 2 -> login ok

try {

	$mail = $_POST["mail"];
	$password = $_POST["password"];

	if ($dbh) {

		if (isset($mail)) {
			$params = [$mail];
			$sql = "SELECT
						Email 
						,Password
						,FlAdmin
					FROM Utenti
					WHERE Email = ?";
			$query = query($dbh, $sql, $params);
	
			if ($query->status) {
				if ($query->rows && count($query->rows) > 0) {
					$utente = $query->rows[0];

					if (isset($password) && password_verify($password, $utente->Password)) {

						//Tolgo la password, non voglio vederla anche se scriptata
						unset($utente->password);

						$response->response = $utente;
						$response->status = 2;

						$_SESSION["admin"] = $utente->FlAdmin;
					} else {
						$response->response = "Email e/o password sbagliati.";
					}
				} else {
					$response->response = "Non risulti registrato. Verifica di aver inserito i dati corretti o registrati";
					$response->status = 1;
				}
			} else {
				$response->response = $query->error;
				$response->status = 1;
			}
		} else {
			$response->response = "Errore durante il login.";
		}
	} else {
		$response->response = "Connessione database fallita";
		$response->status = 1;
	}
} catch (Exception $e) {
	$response->response = "Fatal error: $e";
	$response->status = 1;
	echo $e->getMessage();
}

$_SESSION["logged"] = $response;

if($_SESSION["logged"]->status == 2) {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/areaPrivata.php?pageName=principale");
} else {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
}

?>