<?php

require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";

$output = file_get_contents("../HTML/info.html");
$output = str_replace('<a href="info.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Informazioni"),$output);
if(isset($_SESSION['response'])){
$output = str_replace("<risultato></risultato>",$_SESSION['response']->response,$output);
unset($_SESSION['response']);
}
echo $output;


?>