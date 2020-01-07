<?php
require_once "../PHP/modulesInit.php";


$output = file_get_contents("../HTML/Info.html");
$output = str_replace('<a href="Info.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Informazioni"),$output);

echo $output;


?>