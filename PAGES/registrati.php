<?php
require_once "../PHP/modulesInit.php";

require("../PHP/config/config.php");
require("../PHP/api/beansMaps.php");
require("../PHP/api/fnQuery.php");
require("../PHP/api/fnFind.php");

$output = file_get_contents("../HTML/registrati.html");
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Registrazione"),$output);

echo str_replace("<menu></menu>",modulesInit::menu(),$output);

unset($_SESSION["registrazione"]);
?>
