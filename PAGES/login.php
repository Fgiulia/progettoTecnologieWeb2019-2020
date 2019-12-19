<?php
require_once "../PHP/modulesInit.php";

$output = file_get_contents("../HTML/login.html");
echo str_replace("<menu></menu>",modulesInit::menu(),$output);

if(!isset($_SESSION))
    session_start();

if(isset($_SESSION["login"])) {

    $errorMessage = $_SESSION["login"]->response;

    switch($_SESSION["login"]->status) {
        case 0:
            $output = str_replace("<loginError></loginError>","<p id='loginError'>$errorMessage</p>",$output);
            break;
        case 1:
            $output = str_replace("<errorMessage></errorMessage>","<p id='errorMessage'>$errorMessage</p>",$output);
            break;
    }
    session_destroy();
}

?>
