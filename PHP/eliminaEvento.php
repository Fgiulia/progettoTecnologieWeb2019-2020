<?php

require("./config/config.php");
require("./api/fnQuery.php");

$response = (Object) [
	"status" => false
	,"response" => "init"
];

try {

    if(isset($_POST["eliminaEvento"])) {
        $animale = $_POST["eliminaEvento"];

        $params = [$animale];
        $sql = "DELETE FROM Eventi WHERE ID = ?";
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


$_SESSION["messagge"] = $response->response;

if($response->status) {
	header("Location: $url/PAGES/areaPrivata.php?pageName=eventi");
} else {
	header("Location: $url/PAGES/paginaVuota.php");
}

?>