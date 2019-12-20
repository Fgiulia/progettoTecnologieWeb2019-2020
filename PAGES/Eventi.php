<?php
require_once "../PHP/modulesInit.php";


$output = file_get_contents("../HTML/Eventi.html");
$output = str_replace('<a href="Eventi.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Eventi"),$output);

echo $output;


?>