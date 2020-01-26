<?php

require_once "../PHP/modulesInit.php";
require("config/config.php");
require("api/fnQuery.php");

if (!isset($_SESSION))
session_start();

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
                $sql = "INSERT INTO Messaggi (Nome,Cognome,Email,NumeroTelefono,Messaggio) 
                        VALUES (?,?,?,?,?)";
                $query = query($dbh, $sql, $params);

                if ($query->status) {
                    $response->response = "<p class=\"successMessage\">Messaggio inviato.</p>";
                    $response->status = true;
                } else  {
                    $response->response = "<p class=\"errorMessage\">Si &egrave; verificato un errore durante l&apos;invio.</p>";
                }
            }
            else
            $response->response = "<p class=\"errorMessage\">Non &egrave; possibile procedere all&apos;invio del messaggio perch&egrave; non sono stati inseriti tutti i cambi obbligatori in modo corretto o il numero di telefono inserito non &egrave; valido. Ricorda che il campo telefono deve contenere un numero telefonico valido o essere vuoto.</p>";

        }
        else
        $response->response = "<p class=\"errorMessage\">Impossibile connettersi al database.</p>";
        $_SESSION["response"] = $response;
        header("location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/info.php#contatti");
        

    
?>