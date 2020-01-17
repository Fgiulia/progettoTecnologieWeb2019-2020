<?php

require("config/config.php");
require("api/fnQuery.php");

$response = (Object) [
	"status" => false
	,"response" => "init"
];



    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $telefono = $_POST["numeroTelefono"];
    $messaggio = $_POST["messaggio"];
    
    if ($dbh) {
        
        $params = [$nome, $cognome, $email, $telefono, $messaggio];
        $sql = "INSERT INTO messaggi (Nome,Cognome,Email,NumeroTelefono,Messaggio) 
                VALUES (?,?,?,?,?)";
        $query = query($dbh, $sql, $params);

        if ($query->status) {
            $response->response = "Messaggio inviato";
            $response->status = true;
        } else  {
            $response->response = "Si è verificato un errore durante l'invio";
        }
    }
    else
        echo "impossibile connettersi al database";
    
    echo $response->response;
    

    ?>