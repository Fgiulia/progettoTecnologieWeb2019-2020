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
            
        }
    }
?>
