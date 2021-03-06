<?php

require("./config/config.php");
require("./api/fnQuery.php");

$response = (Object) [
	"status" => false
	,"response" => "init"
];

try {

    if(isset($_POST["eliminaAnimale"])) {
        $animale = $_POST["eliminaAnimale"];

        $params = [$animale];
        $sql = "DELETE FROM Animali WHERE NomeComune = ?";
        $query = query($dbh, $sql, $params);

        if ($query->status) {
            $response->status = true;
        } else  {
            $response->response = $query->error;
        }
    }
    
} catch(Exception $e) {
    $response->response = "Fatal error";
    echo $e->getMessage();
}


$_SESSION["messagge"] = $response;

if($response->status) {
	header("Location: $url/PAGES/areaPrivata.php?pageName=animali");
} else {
	header("Location: $url/PAGES/paginaVuota.php");
}

?>