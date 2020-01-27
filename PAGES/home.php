<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractions.php";

#funzione per sapere la data odierna
    $oggi = date("d/m/Y");
    $prossimiEventi = "<div class=\"prossimiEventi\">";

    $oggettoPagina = new sqlInteractions();
    $connessione = $oggettoPagina->apriConnessioneDB();

    if($connessione){
        $evento = $oggettoPagina->getProssimoEvento();

        if($evento==null){
            $prossimiEventi .= "<p class=\"dataOdierna\">Oggi, ".$oggi."</p><p class=\"messaggio\">Non ci sono eventi in programma al Parco Faunistico Euganeo.</p></div>";
        }
        else{
            foreach($evento as $event)
            $prossimiEventi .= "<div class=\"dataOdierna\">In data: ".date('d/m/Y', strtotime($event['Data']))."</div>
                                <div class=\"eventName\">".$event['Nome']."</div>
                                <div class=\"eventDesc\">".$event['Descrizione']."</div>
                                <div class=\"eventPrice\">Costo: &euro; ".$event['Prezzo']."</div>
                                <div class=\"buttonHome\"><a href=\"acquista.php\">PRENOTA ORA</a></div>
                                </div>";
        }
    }
    else{
        $prossimiEventi .= "<p class=\"errorMessage\">Connessione al database degli eventi fallita. Per favore, riprova.</p></div>";
    }

    $output = file_get_contents("../HTML/home.html");
    $output = str_replace('<a href="home.php">','<a>',$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Homepage"),$output);
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<prossimiEventi></prossimiEventi>",$prossimiEventi,$output);

    echo $output;
?>
