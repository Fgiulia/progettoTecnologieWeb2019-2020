<?php
    require_once "../PHP/modulesInit.php";

    $output = file_get_contents("../HTML/registrati.html");
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Registrazione"),$output);
    echo str_replace("<menu></menu>",modulesInit::menu(),$output);

    unset($_SESSION["registrazione"]);
?>
