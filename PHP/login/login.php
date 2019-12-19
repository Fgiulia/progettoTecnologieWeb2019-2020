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
	$response->response = "Fatal error: $e";
	echo $e->getMessage();
}

$_SESSION["login"]  = $response;
echo json_encode($response);

if($response->status) {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/home.php");
} else {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
}

?>