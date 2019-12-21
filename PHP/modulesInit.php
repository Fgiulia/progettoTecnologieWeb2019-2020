<?php
    class modulesInit{
        #funzione per scrivere i breadcrumb
        public static function breadcrumb(...$sequenza){
            $breadcrumb = "Ti trovi in: Home ";
            foreach($sequenza as $element){
                $breadcrumb .= "> $element ";
            }
            return "<p class=\"map-position\">$breadcrumb</p>";
        }

        #funzione per creare il menu'
        public static function menu(){
            if(!isset($_SESSION)) {
                session_start();
            }

            $menu_form = '<div id="menu">'."\n"
                        .'  <a class="menuItem" href="home.php">Home</a>'."\n"
                        .'  <div class="closeMenu">'."\n"
                        .'      <div id="chiudiMenu">'."\n"
                        .'      </div>'."\n"
                        .'  </div>'."\n"
                        .'  <div class="dropdown menuItem">'."\n"
                        .'      <a href="" class="dropbtn">Animali</a>'."\n"
                        .'      <div class="dropdown-content">'."\n"
                        .'          <a href="animali.php">Tutti gli animali</a>'."\n"
                        .'          <a href="cuccioli.php">I cuccioli</a>'."\n"
                        .'      </div>'."\n"
                        .'  </div>'."\n"
                        .'  <a class="menuItem" href="">Eventi</a>'."\n"
                        .'  <div class="dropdown menuItem">'."\n"
                        .'      <a href="" class="dropbtn">Informazioni</a>'."\n"
                        .'      <div class="dropdown-content">'."\n"
                        .'          <a href="">Contattaci</a>'."\n"
                        .'      </div>'."\n"
                        .'  </div>'."\n"
                        .'  <a class="menuItem" href="">Acquista</a>'."\n";
            #gestione di accedi area personale
            if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
                $menu_form .= '<div class="dropdown menuItem">'."\n"
                             .'   <a href="" class="dropbtn">Area Personale</a>'."\n"
                             .'   <div class="dropdown-content">'."\n"
                             .'      <a href="areaPrivata.php">Pannello Amministrativo</a>'."\n"
                             .'      <a href="">Logout</a>'."\n"
                             .'   </div>'."\n"
                             .'</div>'."\n";
            }
            else{
                if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) { //login effettuato correttamente
                    $menu_form .= '<div class="dropdown menuItem">'."\n"
                                 .'   <a href="" class="dropbtn"><a href="">Area Personale</a></a>'."\n"
                                 .'   <div class="dropdown-content">'."\n"
                                 .'      <a href="areaPrivata.php">I tuoi acquisti</a>'."\n"
                                 .'      <a href="">Modifica i tuoi dati</a>'."\n"
                                 .'      <a href="">Logout</a>'."\n"
                                 .'   </div>'."\n"
                                 .'</div>'."\n";
                }
                else{
                    $menu_form .= '   <a class="menuItem" href="login.php">Accedi</a>'."\n";
                }
            }
            $menu_form .= '   <a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>'."\n";
            $menu_form .= '</div>'."\n";

            return $menu_form;
        }
    }
?>
