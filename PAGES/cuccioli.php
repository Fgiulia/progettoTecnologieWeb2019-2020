<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractios.php";

    $oggettoPagina = new sqlInteractions();
    $connessione = $oggettoPagina->apriConnessioneDB();

    if($connessione){
        $cuccioli = $oggettoPagina->getCuccioli();

        if($cuccioli==null){
            $stringaCuccioli = "<p class=\"msgErr\">Non sono presenti cuccioli in questo momento al Parco Faunistico Euganeo.</p>";
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
        $stringaCuccioli = "<p class=\"msgErr\">Connessione al database degli animali fallita.</p><p class=\"msgErr\">Per favore, riprova.</p>";
    }
    
    $output = file_get_contents("../HTML/cuccioli.html");
    $output = str_replace('<a href="cuccioli.php">','</a>',$output);
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Animali >> Cuccioli'),$output);
    $output = str_replace("<selezionaCuccioli></selezionaCuccioli>",$stringaCuccioli,$output);

    echo $output;
?>
