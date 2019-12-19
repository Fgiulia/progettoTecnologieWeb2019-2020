<?php
require_once "../PHP/modulesInit.php";


$output = file_get_contents("../HTML/home.html");
echo str_replace('<a href="home.php">','</a>',
     str_replace("<menu></menu>",modulesInit::menu(),
     str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb(),$output)));

?>
