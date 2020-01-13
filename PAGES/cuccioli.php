<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractios.php";

$output = file_get_contents("../HTML/cuccioli.html");
$output = str_replace('<a href="cuccioli.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Animali > Cuccioli'),$output);

$oggettoPagina = new sqlInteractions();
$connessione = $oggettoPagina->apriConnessioneDB();

if($connessione){
    $cuccioli = $oggettoPagina->getCuccioli();

    if($cuccioli==null){
        $stringaCuccioli = "<p>Non sono presenti cuccioli in questo momento al Parco Faunistico Euganeo.</p>";
    }
    else{
        $stringaCuccioli = "<dl id=\"risultatiCuccioli\">";
        foreach($cuccioli as $puppies){
			$stringaCuccioli .= "<dt>".$puppies['NomeProprio']."</dt><dt>".$puppies['Ritratto']."</dt><dt>".$puppies['NomeComune']."</dt>";
			}
			$stringaCuccioli .= "</dl>";
    }
}
else{
    $stringaCuccioli = "Connessione al database degli animali fallita. Riprovare";
}

$output = str_replace("<selezionaCuccioli></selezionaCuccioli>",$stringaCuccioli,$output);

echo $output;

?>
