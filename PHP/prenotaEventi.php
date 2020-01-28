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
  $persone = $_POST["NumeroPersone"];
  $nomeEvento = $_POST["eventi"];
  $data = date("Ymd");

	if(is_numeric($persone)){
	  if($dbh){
	    $paramsID = [$nomeEvento];
	    $sqlID = "SELECT ID, Prezzo FROM Eventi WHERE Nome = ?";
	    $queryID = query($dbh, $sqlID, $paramsID);

			$evento = $queryID->rows[0];
			$eventoID = $evento->ID;
			$prezzoEvento = $evento->Prezzo;

			$params = [$user, $persone, $eventoID, $data];
			$sql = "INSERT INTO EventiUtenti (
						Utente
						,NumeroPersone
						,IDEvento
						,Data
					) VALUES (?,?,?,?)";
			$query = query($dbh, $sql, $params);

			if ($query->status) {
				$response->response = "Prenotazione effettuata con successo.";
				$response->status = true;
				$totale = ($persone) * ($prezzoEvento);
				$totale = number_format((float)$totale, 2, ',', '.');
			} else  {
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
  $_SESSION["success"] = "Prenotazione effettuata con successo";
	$_SESSION["totale"] = $totale;
	header("Location: $url/PAGES/acquista.php");
} else {
	$_SESSION["messagge"] = "Attenzione input inserito non valido";
	$_SESSION["redirect"] = "acquista";
	header("Location: $url/PAGES/paginaVuota.php");
}

?>
