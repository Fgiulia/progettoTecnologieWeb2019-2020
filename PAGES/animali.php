<?php
require_once "../PHP/modulesInit.php";


$output = file_get_contents("../HTML/animali.html");
echo str_replace('<a href="animali.php">','</a>',
     str_replace("<menu></menu>",modulesInit::menu(),
     str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Tutti gli animali'),$output)));

?>
