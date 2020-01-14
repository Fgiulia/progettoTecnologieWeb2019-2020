<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractions.php";

    $output = file_get_contents("../HTML/home.html");
    $output = str_replace('<a href="home.php">','</a>',$output);
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Home"),$output);
    /*$output = str_replace("<prossimiEventi></prossimiEventi>",$prossimiEventi,$output);*/

    echo $output;
?>
