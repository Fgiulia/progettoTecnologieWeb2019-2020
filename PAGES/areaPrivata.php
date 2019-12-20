<?php
require_once "../PHP/modulesInit.php";

$output = file_get_contents("../HTML/areaPrivata.html");
$output = str_replace('<a href="areaPrivata.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Area Personale"),$output);

echo $output;
//$eventi = find("EventoBean", null);

?>