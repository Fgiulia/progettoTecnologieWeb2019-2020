<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractions.php";

    $oggettoPagina = new sqlInteractions();
    $connessione = $oggettoPagina->apriConnessioneDB();

    if($connessione){
        $cuccioli = $oggettoPagina->getCuccioli();

        if($cuccioli==null){
            $stringaCuccioli = "<p class=\"messaggio\">Non sono presenti cuccioli in questo momento al Parco Faunistico Euganeo.</p>";
        }
        else{
            $stringaCuccioli = "<div id=\"risultatiCuccioli\">";
            foreach($cuccioli as $puppies){
                $stringaCuccioli .= "<div class=\"containerAnimal\">
                                     <div class=\"namePuppy\">".$puppies['NomeProprio']."</div>
                                     <div class=\"photoAnimal\"><img src=\"".$puppies['Immagine']."\" alt=\"".$puppies['DescrizioneImmagine']."\" /></div>
                                     <div class=\"nameAnimal\">".$puppies['NomeComune']."</div>
                                     <div class=\"scientificNameAnimal\">".$puppies['NomeScientifico']."</div>
                                     <div class=\"descAnimal\">".$puppies['DescrizioneAnimale']."</div>
                                     </div>";
            }
            $stringaCuccioli .= "</div>
                                 <div class=\"clear\"></div>";
        }
    }
    else{
        $stringaCuccioli = "<p class=\"errorMessage\">Connessione al database degli animali fallita. Per favore, riprova.</p>";
    }
    
    $output = file_get_contents("../HTML/cuccioli.html");
    $output = str_replace('<a href="cuccioli.php">','<a>',$output);
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Animali >> Cuccioli'),$output);
    $output = str_replace("<selezionaCuccioli></selezionaCuccioli>",$stringaCuccioli,$output);

    echo $output;
?>
