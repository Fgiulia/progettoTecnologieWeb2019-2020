<?php
require_once "../PHP/modulesInit.php";

require("../PHP/config/config.php");

$output = file_get_contents("../HTML/logout.html");
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Logout"),$output);

echo $output;

?>
