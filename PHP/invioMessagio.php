<?php

require_once "../PHP/modulesInit.php";
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
        if( modulesInit::validName($nome)
					&& modulesInit::validName($cognome)
					&& modulesInit::validEmail($email)
                    && (modulesInit::validPhone($telefono)
                    || empty($telefono))
					&& !empty($messaggio)
					) {

            $params = [$nome, $cognome, $email, $telefono, $messaggio];
            $sql = "INSERT INTO messaggi (Nome,Cognome,Email,NumeroTelefono,Messaggio) 
                    VALUES (?,?,?,?,?)";
            $query = query($dbh, $sql, $params);

            if ($query->status) {
                $response->response = "Messaggio inviato";
                $response->status = true;
            } else  {
                $response->response = "Si &egrave; verificato un errore durante l&apos;invio";
            }
        }
        else
        $response->response = "Non &egrave; possibile procedere all&apos;invio perch&egrave; non sono stati inseriti tutti i cambi obbligatori in modo corretto.<br />Verifica di averli inseriti e riprova.";

    }
    else
    $response->response = "Impossibile connettersi al database";
    echo $response->response;

    
?>