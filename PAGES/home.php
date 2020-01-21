<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractions.php";

#funzione per sapere la data odierna
    $oggi = date("d/m/Y");
    $prossimiEventi = "<div class=\"prossimiEventi\">";

    $oggettoPagina = new sqlInteractions();
    $connessione = $oggettoPagina->apriConnessioneDB();

    if($connessione){
        $evento = $oggettoPagina->getProssimoEvento());

        if($evento==null){
            $prossimiEventi .= "<p class=\"dataOdierna\">Oggi&comma; ".$oggi."</p><p class=\"messaggio\">Non ci sono eventi in programma al Parco Faunistico Euganeo&period;</p></div>";
        }
        else{
            foreach($evento as $event)
            $prossimiEventi .= "<div class=\"dataOdierna\">".$event['Data']."</div>
                                <div class=\"eventName\">".$event['Nome']."</div>
                                <div class=\"eventDesc\">".$event['Descrizione']."</div>
                                <div class=\"eventPrice\"> Costo&colon; &euro; ".$event['Prezzo']."</div>
                                <button id=\"buttonHome\" name=\"buttonHome\"><a href=\"acquista.php\">PRENOTA ORA</a></button>
                                </div>";
        }
    }
    else{
        $prossimiEventi .= "<p class=\"errorMessage\">Connessione al database degli eventi fallita&period;<br />Per favore&comma; riprova&period;</p></div>";
    }

    $output = file_get_contents("../HTML/home.html");
    $output = str_replace('<a href="home.php">','</a>',$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Homepage"),$output);
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<prossimiEventi></prossimiEventi>",$prossimiEventi,$output);

    echo $output;
?>
