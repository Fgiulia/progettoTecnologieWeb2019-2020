<?php

//error_reporting(0);
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
            foreach($query->rows as $eventi) {
                $result .= "<div class=\"containerEventi\">
                            <div class=\"nomeEvento\">".$eventi->Nome."</div>
                            <div class=\"dataEvento\"> Evento disponibile in data: ".$eventi->Data."</div>
                            <div class=\"prezzoEvento\">Prezzo biglietto: ".$eventi->Prezzo."€</div>
                            <div class=\"descrizioneEvento\">".$eventi->Descrizione."</div>
                            <form action=\"../PAGES/acquista.php\">
                                <input class=\"buttonPrenota\" type=\"submit\" value=\"PRENOTA ORA\"/>
                            </form>
                            </div>";
            }
            $result .= "</dl>";
            
        } 
        else {
            $result = "Nessun evento disponibile nel giorno selezionato";
        }
    }
    else {
        $result = "<p class=\"msgErr\">La query non è andata a buon fine&period;</p><p class=\"msgErr\">Per favore&comma; riprova&period;</p>";
        
    }
}
else {
    $result = "<p class=\"msgErr\">Connessione al database degli eventi fallita&period;</p><p class=\"msgErr\">Per favore&comma; riprova&period;</p>";
}


$output = str_replace("<eventiselezionati/>",$result,$output);
echo $output;



?>
