<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractions.php";

#funzione per sapere la data odierna
    $prossimiEventi = "<p>Oggi&comma; ".date("d/m/Y");

    $oggettoPagina = new sqlInteractions();
    $connessione = $oggettoPagina->apriConnessioneDB();

    if($connessione){
        $eventi = $oggettoPagina->getEventi();

        if($eventi==null){
            $prossimiEventi .= "<p class=\"msgErr\">Non ci sono eventi in programma in questo momento al Parco Faunistico Euganeo&period;</p>";
        }
        else{
            $prossimiEventi .= "<p id=\"prossimiEventi\">";
            foreach($eventi as $events){
                $prossimiEventi .= "";
                }
                $prossimiEventi .= "</p>";
        }
    }
    else{
        $prossimiEventi .= "<p class=\"msgErr\">Connessione al database degli eventi fallita&period;</p><p class=\"msgErr\">Per favore&comma; riprova&period;</p>";
    }

    $output = file_get_contents("../HTML/home.html");
    $output = str_replace('<a href="home.php">','</a>',$output);
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Home"),$output);
    $output = str_replace("<prossimiEventi></prossimiEventi>",$prossimiEventi,$output);

    echo $output;
?>
