<?php

require_once "../PHP/modulesInit.php";

require("../PHP/config/config.php");
require("../PHP/api/beansMaps.php");
require("../PHP/api/fnQuery.php");
require("../PHP/api/fnFind.php");

$output = file_get_contents("../HTML/eventi.html");
$output = str_replace('<a href="eventi.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Eventi"),$output);

$result ='';
if($dbh) {

    $query = null;

    if(isset($_POST['cercaData'])) {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_POST['cercaData'])){
            $data = $_POST['cercaData'];
            $query=find("EventoBean", (Object)['Data' => $data]);
        }
        else{
            $result = "<p class=\"errorMessage\"> La data deve essere nel formato ANNO-MESE-GIORNO </p>";
            $output = str_replace("<errore></errore>", $result, $output);
            $query=find("EventoBean", null);
        }
    }
    else {
        $query=find("EventoBean", null);
    }
    if ($query->status) {
        if ($query->response && count($query->response) > 0) {
            $result = "<div id=\"risultatiEventi\">";
            $count = 1;
            if (isset($_SESSION["logged"])){
                foreach($query->response as $eventi) {
                    $result .= "<div class=\"containerEventi\">
                                    <div class=\"titoloEvento\">".$eventi->Nome."</div>
                                    <div class=\"dataEvento\"> Evento disponibile in data: ".date('Y-m-d',strtotime($eventi->Data))."</div>
                                    <div class=\"prezzoEvento\">Prezzo biglietto: ".$eventi->Prezzo."€</div>
                                    <div class=\"descrizioneEvento\">".$eventi->Descrizione."</div>
                                    <form class=\"buttonPrenota\" action=\"../PAGES/acquista.php\" method=\"POST\">
                                        <button type=\"submit\" name=\"prenota\" value=\"$eventi->Nome\" class=\"button internal-button\">PRENOTA ORA</button>
                                    </form>
                                </div>";
                }
            }
            else{
                foreach($query->response as $eventi) {
                    $result .= "<div class=\"containerEventi\">
                                    <div class=\"titoloEvento\">".$eventi->Nome."</div>
                                    <div class=\"dataEvento\">Evento disponibile in data: ".date('Y-m-d',strtotime($eventi->Data))."</div>
                                    <div class=\"prezzoEvento\">Prezzo biglietto: ".$eventi->Prezzo."€</div>
                                    <div class=\"descrizioneEvento\">".$eventi->Descrizione."</div>
                                    <form class=\"buttonPrenota\" action=\"../PHP/login/login.php\" method=\"POST\">
                                        <button type=\"submit\" name=\"prenota\" class=\"button internal-button\">PRENOTA ORA</button>
                                    </form>
                                </div>";

            }
        }

        $result .= "</dl>";
            
        } 
        else {
            $result = "<p class=\"errorMessage\">Nessun evento disponibile nel giorno selezionato.<p>";
        }
    }
    else {
        $error = $query->response;
        $result = "<p class=\"errorMessage\">La query non &egrave; andata a buon fine. Per favore, riprova.</p>";
        
    }
}
else {
    $result = "<p class=\"errorMessage\">Connessione al database degli eventi fallita. Per favore, riprova.</p>";
}


$output = str_replace("<eventiselezionati/>",$result,$output);
echo $output;



?>
