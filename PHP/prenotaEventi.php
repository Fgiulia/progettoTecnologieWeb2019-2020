<?php
require("config/config.php");
require("api/fnQuery.php");

$response = (Object) [
	"status" => 0
	,"response" => "init"
];

try {
  $user = $_SESSION["user"];
  $persone = $_POST["NumeroPersone"];
  $nomeEvento = $_POST["eventi"];
  $data = date("Ymd");

  if($dbh){
    $paramsID = [$nomeEvento];
    $sqlID = "SELECT ID FROM Eventi WHERE Nome = ?";
    $queryID = query($dbh, $sqlID, $paramsID);

		$evento = $queryID->rows[0];
		$eventoID = $evento->ID;

		$params = [$user, $persone, $eventoID, $data];
		$sql = "INSERT INTO EventiUtenti (
					Utente
					,NumeroPersone
					,IDEvento
					,Data
				) VALUES (?,?,?,?)";
		$query = query($dbh, $sql, $params);

		if ($query->status) {
			$response->response = "Prenotazione effettuata con successo";
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
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/areaPrivata.php");
} else {
	header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/paginaVuota.php");
}

?>
