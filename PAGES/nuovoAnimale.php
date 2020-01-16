<?php
    require_once "../PHP/modulesInit.php";
    require_once "../PHP/sqlInteractions.php";

    if(!isset($_SESSION))
        session_start();
 #controllo se il login è stato effettuato prima di mostrare la pagina
    if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) {
        $output = file_get_contents("../HTML/nuovoAnimale.html");
        $output = str_replace("<menu></menu>",modulesInit::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",modulesInit::breadcrumb("Pannello amministratore >> Inserimento Nuovo Animale"),$output);
 
 #controllo se i campi obbligatori sono stati inseriti e se sono validi
        if(isset($_POST['nomeComune'])){
            if(preg_match("/^[a-zA-Z ]*$/",$_POST['nomeComune'])){
                if(isset($_POST['nomeScientifico'])){
                    if(preg_match("/^[a-zA-Z ]*$/",$_POST['nomeScientifico'])){
                        if(isset($_POST['famiglia'])){
                            if(preg_match("/^[a-zA-Z ]*$/",$_POST['famiglia'])){
                                $oggettoPagina = new sqlInteractions();
                                $connessione = $oggettoPagina->apriConnessioneDB();
                                if($connessione){
                                    $inserimento = $oggettoPagina->insertAnimal();
                                    if($inserimento){
                                        $nuovoAnimale = "Inserimento nuovo animale avvenuto con successo&period;";
                                    }
                                    else{
                                        $nuovoAnimale = "Inserimento nuovo animale non avvenuto per un problema del database&period;";
                                    }
                                }
                                else{
                                    $nuovoAnimale = "Connessione al database degli animali fallita&period; Non &egrave; possibile procedere con l&apos;inserimento&comma; riprova pi&ugrave; tardi&period;";
                                }
                            }
                            else{
                                $nuovoAnimale = "La famiglia inserita non &egrave; valido&comma; pu&ograve; contenere solo lettere e spazi&comma; riprova&period;";
                            }
                        }
                        else{
                            $nuovoAnimale = "Non è possibile procedere all&apos;inserimento del nuovo animale perch&egrave; non sono presenti tutti i cambi obbligatori&comma; inseriscili e riprova&period;";
                        }
                    }
                    else{
                        $nuovoAnimale = "Il nome scientifico inserito non &egrave; valido&comma; pu&ograve; contenere solo lettere e spazi&comma; riprova&period;";
                    }
                }
                else{
                    $nuovoAnimale = "Non è possibile procedere all&apos;inserimento del nuovo animale perch&egrave; non sono presenti tutti i cambi obbligatori&comma; inseriscili e riprova&period;";
                }
            }
            else{
                $nuovoAnimale = "Il nome comune inserito non &egrave; valido&comma; pu&ograve; contenere solo lettere e spazi&comma; riprova&period;";
            }
            $output = str_replace("<inserimentoNuovoAnimale></inserimentoNuovoAnimale>","<p class\"messaggio\">".$nuovoAnimale."</p>",$output);
        }
        echo $output;
    }

#se il login non è stato effettuato
    else {
        $response = (Object) [
            "status" => -1
            ,"response" => "Attenzione&colon; non hai effettuato il login&comma; verrai reindirizzato alla pagina di login&period;"
        ];
        $_SESSION["logged"] = $response;

        echo modulesInit::setMessaggio($response->response, true);

        header("refresh:5; url= http://localhost:8080/progettoTecnologieWeb2019-2020/PAGES/login.php");
    }
?>
