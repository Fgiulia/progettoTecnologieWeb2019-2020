<?php
require_once "../PHP/modulesInit.php";


$output = file_get_contents("../HTML/nuovoEvento.html");
echo str_replace("<menu></menu>",modulesInit::menu(),$output);
?>
