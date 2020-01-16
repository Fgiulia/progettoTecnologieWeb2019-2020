<?php

require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";

$output = file_get_contents("../HTML/info.html");
$output = str_replace('<a href="info.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Informazioni"),$output);

echo $output;


?>