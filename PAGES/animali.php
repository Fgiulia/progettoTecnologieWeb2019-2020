<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractions.php";

#controllo sul testo in input
    $validText=true;
    if(isset($_POST['cerca'])){
        if(!preg_match("/^[a-zA-Z ]*$/",$_POST['cerca'])){
            $validText = false;
        }
    }

#se non vengono inseriti filtri di ricerca (per esempio la prima volta che carico la pagina)
    if(!(isset($_POST['testo']) || isset($_POST['scegliFamiglia']) || isset($_POST['sezioneParco']))){
        $_POST['testo'] = null;
        $_POST['scegliFamiglia'] = null;
        $_POST['sezioneParco'] = null;
    }

    $oggettoPagina = new sqlInteractions();
    $connessione = $oggettoPagina->apriConnessioneDB();
    
    if($connessione){
        $animali = $oggettoPagina->getResultSearch();

        if($animali==null){
            $stringaAnimali = "<p>Risultati per \" ".$_POST['testo']." ".$_POST['scegliFamiglia']." ".$_POST['sezioneParco']." \"</p>";
            $stringaAnimali .= "<p class=\"msgErr\">Non abbiamo trovato nessun animale collegato alla tua ricerca&period;</p><p class=\"msgErr\">Pu&ograve; essere che non siano presenti gli animali che cerchi in questo momento al Parco Faunistico Euganeo&period;</p>";
        }
        else{
            if($_POST['testo']!=null || $_POST['scegliFamiglia']!=null || $_POST['sezioneParco']!=null){
                $stringaAnimali = "<p>Risultati per \" ".$_POST['testo']." ".$_POST['scegliFamiglia']." ".$_POST['sezioneParco']." \"</p><dl id=\"risultatiAnimali\">";
            }
            else{
                $stringaAnimali = "<dl id=\"risultatiAnimali\">";
            }
            foreach($animali as $animals){
                $stringaAnimali .= "<dt>".$animals['Ritratto']."</dt><dt>".$animals['NomeComune']."</dt><dt>".$animals['NomeScientifico']."</dt><dt>".$animals['Descrizione']."</dt>";
                }
                $stringaAnimali .= "</dl>";
        }
    }
    else{
        $stringaAnimali = "<p class=\"msgErr\">Connessione al database degli animali fallita&period;</p><p class=\"msgErr\">Per favore&comma; riprova&period;</p>";
    }

#se la ricerca non è valida (input non valido)
    if($validText==false){
        $stringaAnimali = "<p class=\"msgErr\">La ricerca non &egrave; valida&comma; per favore riprova&period;</p>";
    }

    $output = file_get_contents("../HTML/animali.html");
    $output = str_replace('<a href="animali.php">','</a>',$output);
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Animali >> Tutti gli animali'),$output);
    $output = str_replace("<tuttiAnimali></tuttiAnimali>",$stringaAnimali,$output);

    echo $output;
?>
