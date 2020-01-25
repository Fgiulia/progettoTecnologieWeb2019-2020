<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractions.php";

if(!isset($_SESSION))
	session_start();

$SqlInterf= new sqlInteractions();
$options = "";
$eventi = array();
$output = file_get_contents("../HTML/acquista.html");

if($SqlInterf->apriConnessioneDB()){
  if(isset($_POST['searchDate'])){
    $dataIns = $_POST['searchDate'];
    $eventi = $SqlInterf->getEventi($dataIns);
    if(isset($eventi)){
      $evento = $eventi[0];
      $nomeEvento = $evento['Nome'];
      $options = $options."<option>$nomeEvento</option>";
			$output = str_replace("<tagErrore></tagErrore>","<div></div>",$output);
    }
    else{
      $errore = "Nessun evento nella data selezionata";
      $output = str_replace("<tagErrore></tagErrore>","<p class='errorMessage'>$errore</p>",$output);
    }
    unset($_POST['searchDate']);
  }
  elseif(isset($_POST['prenota'])){
    $nomeEvento = $_POST['prenota'];
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
else{
  $errore = "Connessione a Database fallita";
  $output = str_replace("<tagErrore></tagErrore>","<p class='errorMessage'>$errore</p>",$output);
}

if(isset($_SESSION["success"])){
  $successo = $_SESSION["success"];
  $output = str_replace("<tagSuccesso></tagSuccesso>","<p class='successMessage'>$successo</p>",$output);
  unset($_SESSION["success"]);
}
else{
	$output = str_replace("<tagSuccesso></tagSuccesso>","<div></div>",$output);
}

$output = str_replace('<a href="acquista.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Acquista"),$output);
$output = str_replace("<opzioni></opzioni>",$options,$output);


if(!isset($_SESSION["logged"])) {
  $_SESSION["redirect"] = "login";
  $_SESSION["messagge"] = "Devi effettuare l&apos;accesso prima di procedere con gli acquisti.";
  header("Location: http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/paginaVuota.php");
}
else {
  echo $output;
}
?>
