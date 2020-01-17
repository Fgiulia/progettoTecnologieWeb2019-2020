<?php
require_once "../PHP/modulesInit.php";

$output = file_get_contents("../HTML/login.html");
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Accedi"),$output);

if(!isset($_SESSION))
    session_start();

if(isset($_SESSION["logged"])) {

    $errorMessage = $_SESSION["logged"]->response;

    switch($_SESSION["logged"]->status) {
        case 0:
            $output = str_replace("<loginError></loginError>","<p class='errorMessage'>$errorMessage</p>",$output);
            break;
        case 1:
            $output = str_replace("<errorMessage></errorMessage>","<p class='errorMessage'>$errorMessage</p>",$output);
            break;
    }
    // pulisco, così al refresh non vedrò di nuovo il messaggio
    unset($_SESSION["logged"]);
}

echo $output;

?>
