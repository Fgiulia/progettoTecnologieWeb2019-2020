<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/sqlInteractios.php";

if((isset($_POST['cerca']) || isset($_POST['scegliFamiglia']))!=true){
    $_POST['cerca']=null;
    $_POST['scegliFamiglia']=null;
}

$output = file_get_contents("../HTML/animali.html");
$output = str_replace('<a href="animali.php">','</a>',$output);
$output = str_replace("<menu></menu>",modulesInit::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Animali > Tutti gli animali'),$output);

$oggettoPagina = new sqlInteractions();
$connessione = $oggettoPagina->apriConnessioneDB();

if($connessione){
    $cercaTesto = $_POST['cerca'];
    if($cercaTesto!=null){
        $animali = $oggettoPagina->getSelect($cercaTesto);
    }
    else{
        $cercaTesto = $_POST['scegliFamiglia'];
        if($cercaTesto!=null){
            $animali = $oggettoPagina->getFamily($cercaTesto);
        }
        else{
            $animali = $oggettoPagina->getSelect($cercaTesto);
        }
    }

    if($animali==null){
        $stringaAnimali = "<p>Non abbiamo trovato nessun animale collegato alla tua ricerca.</p><p>Pu&ograve; essere che non siano presenti gli animali che cerchi in questo momento al Parco Faunistico Euganeo.</p>";
    }
    else{
        $stringaAnimali = "<p></p>";
        if($cercaTesto!=null){
            $stringaAnimali .= "<p>Risultati per \"".$cercaTesto."\"</p>";
        }
        $stringaAnimali .= "<dl id=\"risultatiAnimali\">";
        foreach($animali as $animals){
			$stringaAnimali .= "<dt>".$animals['Ritratto']."</dt><dt>".$animals['NomeComune']."</dt><dt>".$animals['NomeScientifico']."</dt>";
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
