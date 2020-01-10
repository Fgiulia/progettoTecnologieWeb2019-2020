<?php
require_once "../PHP/modulesInit.php";

$output = file_get_contents("../HTML/animali.html");
$output = str_replace('<a href="animali.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Animali > Tutti gli animali'),$output);

echo $output;

?>
