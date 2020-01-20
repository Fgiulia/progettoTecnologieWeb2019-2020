<?php

error_reporting(0);
require_once "../PHP/modulesInit.php";
require("../PHP/config/config.php");
require("../PHP/api/fnQuery.php");

$output = file_get_contents("../HTML/eventi.html");
$output = str_replace('<a href="eventi.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Eventi"),$output);


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
            $result .= "<dl id=\"risultatiEventi\">";
            foreach($query->rows as $eventi) {
                $result .= "<dt>".$eventi->Nome."</dt><dt>".$eventi->Prezzo."</dt><dt>".$eventi->Data."</dt><dt>".$eventi->Descrizione."</dt>";
            }
            $result .= "</dl>";
            $output = str_replace("<eventiselezionati/>",$result,$output);
          
        } 
        else {
            $result = "Nessun evento disponibile nel giorno selezionato";
            $output = str_replace("<eventiselezionati/>",$result,$output);
        }
        
    }
    else {
        $result .= "<p class=\"msgErr\">La query non è andata a buon fine&period;</p><p class=\"msgErr\">Per favore&comma; riprova&period;</p>";
        $output = str_replace("<eventiselezionati/>",$result,$output);
    }
}
else {
    $result .= "<p class=\"msgErr\">Connessione al database degli eventi fallita&period;</p><p class=\"msgErr\">Per favore&comma; riprova&period;</p>";
    $output = str_replace("<eventiselezionati/>",$result,$output);
}



echo $output;
if(isset($data))


?>
