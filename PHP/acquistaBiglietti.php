<?php
require("config/config.php");
require("api/fnQuery.php");

$response = (Object) [
	"status" => 0
	,"response" => "init"
];

try {
  $user = $_SESSION["user"];
  $ridotti = $_POST["quantitaRidotti"];
  $interi = $_POST["quantitaInteri"];
  $data = date("Ymd");

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
					$response->response = "Acquisto effettuato con successo";
					$response->status = true;
				} else  {
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
  $_SESSION["redirect"] = "areaPrivata";
  $_SESSION["messagge"] = "Acquisto effettuato con successo";
  header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/paginaVuota.php");
} else {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/paginaVuota.php");
}

?>
