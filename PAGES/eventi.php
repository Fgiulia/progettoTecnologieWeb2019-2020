<?php

require_once "../PHP/modulesInit.php";
require("../PHP/config/config.php");
require("../PHP/api/fnQuery.php");

$output = file_get_contents("../HTML/eventi.html");
$output = str_replace('<a href="eventi.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Eventi"),$output);

$result ='';
if($dbh) {

    if(isset($_POST['cercaData'])) {
        $data = $_POST['cercaData'];
        $sql = "SELECT * FROM Eventi
        WHERE Data LIKE '{$data}%'";
        $query=query($dbh,$sql,$data);
    }
    else {
    $params = array();    
    $sql = "SELECT * FROM Eventi";
    $query=query($dbh,$sql,$params);
    }
    if ($query->status) {
        if ($query->rows && count($query->rows) > 0) {
            $result = "<div id=\"risultatiEventi\">";
            $count = 1;
            if (isset($_SESSION["logged"])){
                foreach($query->rows as $eventi) {
                    $result .= "<div class=\"containerEventi\">
                                    <div class=\"titoloEvento\">".$eventi->Nome."</div>
                                    <div class=\"dataEvento\"> Evento disponibile in data: ".$eventi->Data."</div>
                                    <div class=\"prezzoEvento\">Prezzo biglietto: ".$eventi->Prezzo."€</div>
                                    <div class=\"descrizioneEvento\">".$eventi->Descrizione."</div>
                                    <form class=\"buttonPrenota\" action=\"../PAGES/acquista.php\" method=\"POST\">
                                        <button type=\"submit\" name=\"prenota\" value=\"$eventi->Nome\" class=\"button internal-button\">PRENOTA ORA</button>
                                    </form>
                                </div>";
                }
            }
            else{
                foreach($query->rows as $eventi) {
                    $result .= "<div class=\"containerEventi\">
                                    <div class=\"titoloEvento\">".$eventi->Nome."</div>
                                    <div class=\"dataEvento\">Evento disponibile in data: ".$eventi->Data."</div>
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
            $result = "Nessun evento disponibile nel giorno selezionato";
        }
    }
    else {
        $result = "<p class=\"msgErr\">La query non &egrave; andata a buon fine. Per favore, riprova.</p>";
        
    }
}
else {
    $result = "<p class=\"msgErr\">Connessione al database degli eventi fallita. Per favore, riprova.</p>";
}


$output = str_replace("<eventiselezionati/>",$result,$output);
echo $output;



?>
