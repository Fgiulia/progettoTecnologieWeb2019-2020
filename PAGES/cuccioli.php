<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractios.php";

$selezionaCuccioli = "cuccioli trovati nel database";

$output = file_get_contents("../HTML/cuccioli.html");
$output = str_replace('<a href="cuccioli.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Animali > Cuccioli'),$output);
$output = str_replace("<selezionaCuccioli></selezionaCuccioli>",$selezionaCuccioli,$output);
/*$output = str_replace("<selezionaCuccioli></selezionaCuccioli>",sqlInteraction::sqlSelect('Cuccioli'),$output);*/

echo $output;

?>
