<?php
require("../config/config.php");
require("../api/base/fnQuery.php");
require("../api/session_recovery.php");

$response = (Object) [
	"status" => false
	,"response" => "init"
];

try {

	$mail = $_POST["mail"];
	$passw = $_POST["password"];
	$_POST["password"] = "";

	if ($dbh) {

		if (isset($mail)) {
			$params = [$mail];
			$sql = "SELECT
						Email 
						,Password
						,Admin
					FROM Utenti
					WHERE Email = ?";
			$query = query($dbh, $sql, $params);
	
			if ($query->status) {
				if ($query->rows && count($query->rows) > 0) {
					$utente = $query->rows[0];

					if (isset($password) && password_verify($password, $utente->password)) {

						//Tolgo la password, non voglio vederla anche se scriptata
						unset($utente->password);

						$_SESSION[$session_logged] = $utente;

						$response->response = $utente;
						$response->status = true;
					} else {
						$response->response = "Login errato";
					}
				} else {
					$response->response = "Login errato";
				}
			} else {
				$response->response = $query->error;
			}
		} else {
			$response->response = "Login errato";
		}
	} else {
		$response->response = "Connessione database fallita";
	}
} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

$response->response = $response->status ? $response->response : $response->response;
$_SESSION["login"]  = $response;

?>