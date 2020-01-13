<?php
require_once "../PHP/modulesInit.php";

$output = file_get_contents("../HTML/Acquista.html");
$output = str_replace('<a href="acquista.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Acquista"),$output);

echo $output;

?>
