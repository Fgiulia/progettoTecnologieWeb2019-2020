<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractions.php";

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
        $stringaAnimali = "";
        
        if($_POST['testo']!=null || $_POST['scegliFamiglia']!=null || $_POST['sezioneParco']!=null){                
            $stringaAnimali .= "<p class=\"messaggioRicerca\">Hai cercato: ";
            if($_POST['testo']!=null){
                $stringaAnimali .= "\"".$_POST['testo']."\" in ";
            }
            if($_POST['scegliFamiglia']!=null){
                $stringaAnimali .= $_POST['scegliFamiglia']." presenti in ";
            }
            else{
                $stringaAnimali .= "tutti gli animali presenti in ";
            }
            if($_POST['sezioneParco']!=null){
                $stringaAnimali .= $_POST['sezioneParco'].".</p>";
            }
            else{
                $stringaAnimali .= "tutti i continenti.</p>";
            }
        }

        if($animali==null){
            $stringaAnimali .= "<p class=\"messaggio\">Non abbiamo trovato nessun animale collegato alla tua ricerca.<br />Pu&ograve; essere che non siano presenti gli animali che cerchi in questo momento al Parco Faunistico Euganeo.</p>";
        }
        else{
            $stringaAnimali .= "<div id=\"risultatiAnimali\">";
            foreach($animali as $animals){
                $stringaAnimali .= "<div class=\"containerAnimal\">
                                    <div class=\"photoAnimal\"><img src=\"".$animals['Immagine']."\" alt=\"".$animals['DescrizioneImmagine']."\" /></div>
                                    <div class=\"nameAnimal\">".$animals['NomeComune']."</div>
                                    <div class=\"scientificNameAnimal\">".$animals['NomeScientifico']."</div>
                                    <div class=\"descAnimal\">".$animals['DescrizioneAnimale']."</div>
                                    </div>";
                }
            $stringaAnimali .= "</div>
                                <div class=\"clear\"></div>";
        }
    }
    else{
        $stringaAnimali = "<p class=\"errorMessage\">Connessione al database degli animali fallita. Per favore, riprova.</p>";
    }

#se la ricerca non è valida (input non valido)
    if(isset($_POST['testo'])){
        if(!(preg_match("/^[a-zA-Z ]*$/",$_POST['testo']))){
            $stringaAnimali = "<p class=\"errorMessage\">La ricerca non &egrave; valida, per favore riprova.<br />Il nome pu&ograve; contenere solo lettere e spazi.</p>";
        }
    }

    $output = file_get_contents("../HTML/animali.html");
    $output = str_replace('<a href="animali.php">','</a>',$output);
    $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb('Animali >> Tutti gli animali'),$output);
    $output = str_replace("<tuttiAnimali></tuttiAnimali>",$stringaAnimali,$output);

    echo $output;
?>
