<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";

$SqlInterf= new sqlInteractions();
$options = "";
$eventi = array();

if($SqlInterf->apriConnessioneDB()){
  if(isset($_POST['searchDate'])){
    $dataIns = $_POST['searchDate'];
    $eventi = $SqlInterf->getEventi($dataIns);
    $nomeEvento = $eventi['Nome'];
    $options = $options."<option>$nomeEvento</option>";
  }
  else{
    $eventi = $SqlInterf->getAllEventiFromToday();
    if (is_array($eventi) || is_object($eventi)){
      foreach ($eventi as $value) {
        $nomeEvento = $value['Nome'];
        $options = $options."<option>$nomeEvento</option>";
      }
    }
  }
}
$output = file_get_contents("../HTML/Acquista.html");
$output = str_replace('<a href="acquista.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Acquista"),$output);
$output = str_replace("<opzioni></opzioni>",$options,$output);


if(!isset($_SESSION["logged"])) {
  $_SESSION["messagge"] = "Devi effettuare l'accesso prima di procedere con gli acquisti";
  header('location : PAGES/paginaVuota.php');
}
else {
echo $output;
}
?>
