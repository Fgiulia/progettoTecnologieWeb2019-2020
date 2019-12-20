<?php
require_once "../PHP/modulesInit.php";

$output = file_get_contents("../HTML/login.html");
echo str_replace("<menu></menu>",modulesInit::menu(),$output);

if(!isset($_SESSION))
    session_start();

if(isset($_SESSION["logged"])) {

    $errorMessage = $_SESSION["logged"]->response;

    switch($_SESSION["logged"]->status) {
        case 0:
            $output = str_replace("<loginError></loginError>","<p id='loginError'>$errorMessage</p>",$output);
            break;
        case 1:
            $output = str_replace("<errorMessage></errorMessage>","<p id='errorMessage'>$errorMessage</p>",$output);
            break;
    }
}

?>