<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractions.php";

#funzione per sapere la data odierna
    $oggi = date("d/m/Y");
    $prossimiEventi = "<div id=\"prossimiEventi\"><p>Oggi&comma; ".$oggi."</p>";

    $oggettoPagina = new sqlInteractions();
    $connessione = $oggettoPagina->apriConnessioneDB();

    if($connessione){
        $eventi = $oggettoPagina->getEventi($oggi);

        if($eventi==null){
            $prossimiEventi .= "<p class=\"msgErr\">Non ci sono eventi in programma al Parco Faunistico Euganeo&period;</p></div>";
        }
        else{
            $prossimiEventi .= "<div id=\"prossimiEventi\">";
            $prossimiEventi .= "</div></div>";
        }
    }
    else{
        $prossimiEventi .= "<p class=\"msgErr\">Connessione al database degli eventi fallita&period;</p><p class=\"msgErr\">Per favore&comma; riprova&period;</p></div>";
    }

    $output = file_get_contents("../HTML/home.html");
    $output = str_replace('<a href="home.php">','</a>',$output);
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Homepage"),$output);
    $output = str_replace("<prossimiEventi></prossimiEventi>",$prossimiEventi,$output);

    echo $output;
?>
