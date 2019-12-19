<?php
require("../config/config.php");
require("../api/base/fnQuery.php");
require("../api/session_recovery.php");

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
					} else {
						$response->response = "Login errato";
					}
				} else {
					$response->response = "Login errato";
				}
			} else {
				$response->response = $query->error;
				$response->status = 1;
			}
		} else {
			$response->response = "Login errato";
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

$_SESSION["login"]  = $response;

if($_SESSION["login"]->status == 2) {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/home.php");
} else {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
}

?>