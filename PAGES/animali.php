<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractios.php";

$output = file_get_contents("../HTML/animali.html");
$output = str_replace('<a href="animali.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Animali > Tutti gli animali'),$output);

$cercaTesto = $_POST['cerca'];
$cercaFamiglia = $_POST['scegliFamiglia'];

$oggettoPagina = new sqlInteractions();
$connessione = $oggettoPagina->apriConnessioneDB();

if($connessione){
    if($cercaTesto!=null){
        $animali = $oggettoPagina->getSelect($cercaTesto);
    }
    else{
        if($cercaFamiglia!=null){
            $animali = $oggettoPagina->getFamily($cercaFamiglia);
        }
        else{
            $animali = null;
        }
    }

    if($animali==null){
        $stringaAnimali = "<p>Non abbiamo trovato nessun animale collegato alla tua ricerca.</p><p>Pu&ograve; essere che non siano presenti gli animali che cerchi in questo momento al Parco Faunistico Euganeo.</p>";
    }
    else{
        $stringaAnimali = "<dl id=\"risultatiAnimali\">";
        foreach($animali as $animals){
			$stringaAnimali .= "<dt>".$animals['Ritratto']."</dt><dt>".$puppies['NomeComune']."</dt><dt>".$puppies['NomeScientifico']."</dt>";
			}
			$stringaAnimali .= "</dl>";
    }
}
else{
    $stringaAnimali = "Connessione al database degli animali fallita. Riprovare";
}

$output = str_replace("<tuttiAnimali></tuttiAnimali>",$stringaAnimali,$output);


echo $output;

?>
