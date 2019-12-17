<?php
require_once "./modulesInit.php";


$output = file_get_contents("../HTML/home.html");
echo str_replace("<menu></menu>",modulesInit::menu(),$output);
?>
