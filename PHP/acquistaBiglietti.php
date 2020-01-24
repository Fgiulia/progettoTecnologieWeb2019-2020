<?php
require("config/config.php");
require("api/fnQuery.php");

if(!isset($_SESSION))
	session_start();

$response = (Object) [
	"status" => 0
	,"response" => "init"
];

try {
  $user = $_SESSION["user"];
  $ridotti = $_POST["quantitaRidotti"];
  $interi = $_POST["quantitaInteri"];
  $data = date("Ymd");

	if(is_numeric($interi) && is_numeric($ridotti)){
		if ($dbh) {
					$params = [$user, $ridotti, $interi, $data];

					$sql = "INSERT INTO BigliettiUtenti (
								Utente
								,NumRidotti
								,NumInteri
								,Data
							) VALUES (?,?,?,?)";

					$query = query($dbh, $sql, $params);

					if ($query->status) {
						$response->response = "Acquisto effettuato con successo.";
						$response->status = true;
					} else {
			        $response->response = $query->error;
					}
	      } else {
			      $response->response = "Connessione al database fallita.";
	      }
			} else {
					$response->status = false;
				}
} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

if($response->status) {
  $_SESSION["success"] = "Biglietti acquistati con successo";
  header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/acquista.php");
} else {
	$_SESSION["messagge"] = "Attenzione input inserito non valido";
	$_SESSION["redirect"] = "acquista";
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/paginaVuota.php");
}

?>
