<?php
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
        WHERE Data = ?";
        $query=query($dbh,$sql,$data);
    }
    else {
    $params = ["*"];    
    $sql = "SELECT ? FROM Eventi";
    $query=query($dbh,$sql,$params);
    }
    if ($query->status) {
        if ($query->rows && count($query->rows) > 0) {
            $result = $query->rows[0];
            $output = str_replace("<eventiselezionati/>",$result->Nome,$output);
        }
        else {
            $result = "Nessun evento disponibile nel giorno selezionato";
            $output = str_replace("<eventiselezionati/>",$result,$output);
        }
    }

}


    

echo $output;
if(isset($data))
echo $data;
?>
