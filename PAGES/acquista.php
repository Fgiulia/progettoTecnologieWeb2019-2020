<?php
require_once "../PHP/modulesInit.php";


$output = file_get_contents("../HTML/acquista.html");
echo str_replace('<a href="acquista.php">','</a>',
     str_replace("<menu></menu>",modulesInit::menu(),
     str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Acquista'),$output)));

?>
