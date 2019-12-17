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

            $menu_form = '<div id="menu">'."\n";
            $menu_form .= '<a href="">Home</a>'."\n";
            $menu_form .= '<div class="closeMenu">'."\n";
            $menu_form .= '<div id="chiudiMenu">'."\n";
            $menu_form .= '</div>'."\n";
            $menu_form .= '</div>'."\n";
            $menu_form .= '<div class="dropdown">'."\n";
            $menu_form .= '<button class="dropbtn">Animali<i class="fa fa-caret-down"></i></button>'."\n";
            $menu_form .= '<div class="dropdown-content">'."\n";
            $menu_form .= '<a href="">Tutti gli animali</a>'."\n";
            $menu_form .= '<a href="">I cuccioli</a>'."\n";
            $menu_form .= '</div>'."\n";
            $menu_form .= '</div>'."\n";
            $menu_form .= '<a href="">Eventi</a>'."\n";
            $menu_form .= '<div class="dropdown">'."\n";
            $menu_form .= '<button class="dropbtn"><a href="">Informazioni</a><i class="fa fa-caret-down"></i></button>'."\n";
            $menu_form .= '<div class="dropdown-content">'."\n";
            $menu_form .= '<a href="">Contattaci</a>'."\n";
            $menu_form .= '</div>'."\n";
            $menu_form .= '</div>'."\n";
            $menu_form .= '<a href="">Acquista</a>'."\n";
            #gestione di accedi/area personale
            if(isset($_SESSION['email']) && $_SESSION['email']=="admin@admin.com"){
                $menu_form .= '<div class="dropdown">'."\n";
                $menu_form .= '<button class="dropbtn"><a href="">Area Personale</a><i class="fa fa-caret-down"></i></button>'."\n";
                $menu_form .= '<div class="dropdown-content">'."\n";
                $menu_form .= '<a href="">Pannello Amministrativo</a>'."\n";
                $menu_form .= '</div>'."\n";
                $menu_form .= '</div>'."\n";
            }
            else{
                if(isset($_SESSION)){
                    $menu_form .= '<div class="dropdown">'."\n";
                    $menu_form .= '<button class="dropbtn"><a href="">Area Personale</a><i class="fa fa-caret-down"></i></button>'."\n";
                    $menu_form .= '<div class="dropdown-content">'."\n";
                    $menu_form .= '<a href="">Modifica i tuoi dati</a>'."\n";
                    $menu_form .= '</div>'."\n";
                    $menu_form .= '</div>'."\n";
                }
                else{
                    $menu_form .= '<a href="">Accedi</a>'."\n";
                }
            }
            $menu_form .= '<a href="javascript:void(0);" class="icon" onclick="myFunction()">'."\n";
            $menu_form .= '</div>'."\n";

            return $menu_form;
        }
    }
?>
