<?php
    class modulesInit{
        #funzione per scrivere i breadcrumb
        public static function breadcrumb(...$sequenza){
            $breadcrumb = "Ti trovi in: Home ";
            foreach($sequenza as $element){
                $breadcrumb .= "> $element ";
            }
            return "<p id=\"map-position\">$breadcrumb</p>";
        }

        #funzione per creare il menu'
        public static function menu(){
            if(!isset($_SESSION)) {
                session_start();
            }

            $menu_form = '<div id="menu">'."\n"
                        .'  <a href="home.php">Home</a>'."\n"
                        .'  <div class="closeMenu">'."\n"
                        .'      <div id="chiudiMenu">'."\n"
                        .'      </div>'."\n"
                        .'  </div>'."\n"
                        .'  <div class="dropdown">'."\n"
                        .'      <button class="dropbtn">Animali<i class="fa fa-caret-down"></i></button>'."\n"
                        .'      <div class="dropdown-content">'."\n"
                        .'          <a href="animali.php">Tutti gli animali</a>'."\n"
                        .'          <a href="cuccioli.php">I cuccioli</a>'."\n"
                        .'      </div>'."\n"
                        .'  </div>'."\n"
                        .'  <a href="">Eventi</a>'."\n"
                        .'  <div class="dropdown">'."\n"
                        .'      <button class="dropbtn">Informazioni<i class="fa fa-caret-down"></i></button>'."\n"
                        .'      <div class="dropdown-content">'."\n"
                        .'          <a href="">Contattaci</a>'."\n"
                        .'      </div>'."\n"
                        .'  </div>'."\n"
                        .'  <a href="">Acquista</a>'."\n";
            #gestione di accedi area personale
            if(isset($_SESSION['email']) && $_SESSION['email']=="admin@admin.com"){
                $menu_form .= '<div class="dropdown">'."\n"
                             .'   <button class="dropbtn"><a href="">Area Personale</a><i class="fa fa-caret-down"></i></button>'."\n"
                             .'   <div class="dropdown-content">'."\n"
                             .'      <a href="">Pannello Amministrativo</a>'."\n"
                             .'   </div>'."\n"
                             .'</div>'."\n";
            }
            else{
                if(isset($_SESSION["logged"])){
                    $menu_form .= '<div class="dropdown">'."\n"
                                 .'   <button class="dropbtn"><a href="">Area Personale</a><i class="fa fa-caret-down"></i></button>'."\n"
                                 .'   <div class="dropdown-content">'."\n"
                                 .'      <a href="">Modifica i tuoi dati</a>'."\n"
                                 .'   </div>'."\n"
                                 .'</div>'."\n";
                }
                else{
                    $menu_form .= '   <a href="">Accedi</a>'."\n";
                }
            }
            $menu_form .= '   <a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>'."\n";
            $menu_form .= '</div>'."\n";

            return $menu_form;
        }
    }
?>
