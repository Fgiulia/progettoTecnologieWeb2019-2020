<?php
require_once "../PHP/modulesInit.php";

require("../PHP/config/config.php");

if(!isset($_SESSION))
    session_start();

$output = file_get_contents("../HTML/paginaVuota.html");
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb(),$output);

if(isset($_SESSION["messagge"])) {
    $mess = $_SESSION["messagge"]->response;

    $output = str_replace("<messaggio></messaggio>","<p class='messaggio'>$mess</p>",$output);
    unset($_SESSION["messagge"]);
}

echo $output;

header("refresh:5; url= http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/home.php");

?>
