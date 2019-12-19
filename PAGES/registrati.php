<?php
require_once "../PHP/modulesInit.php";


$output = file_get_contents("../HTML/registrati.html");
echo str_replace("<menu></menu>",modulesInit::menu(),$output);
?>
