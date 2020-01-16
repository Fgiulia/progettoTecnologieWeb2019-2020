<?php
require_once "../PHP/modulesInit.php";

$output = file_get_contents("../HTML/eventi.html");
$output = str_replace('<a href="eventi.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Eventi"),$output);

echo $output;

?>
