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
						.'	  <div id="chiudiMenu">'."\n"
						.'	  </div>'."\n"
						.'  </div>'."\n"
						.'  <div class="dropdown menuItem">'."\n"
						.'	  <a href="" class="dropbtn">Animali</a>'."\n"
						.'	  <div class="dropdown-content">'."\n"
						.'		  <a href="animali.php">Tutti gli animali</a>'."\n"
						.'		  <a href="cuccioli.php">I cuccioli</a>'."\n"
						.'	  </div>'."\n"
						.'  </div>'."\n"
						.'  <a class="menuItem" href="">Eventi</a>'."\n"
						.'  <div class="dropdown menuItem">'."\n"
						.'	  <a href="" class="dropbtn">Informazioni</a>'."\n"
						.'	  <div class="dropdown-content">'."\n"
						.'		  <a href="">Contattaci</a>'."\n"
						.'	  </div>'."\n"
						.'  </div>'."\n"
						.'  <a class="menuItem" href="">Acquista</a>'."\n";

			#gestione di accedi area personale
			if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) { //login effettuato correttamente

				if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { //Sono l'admin
					$menu_form .= '<a class="menuItem" href="areaPrivata.php">Pannello Amministrativo</a>'."\n";
				} else {
					$menu_form .= '<a class="menuItem" href="areaPrivata.php">Area Personale</a></a>'."\n";
				}
			} else { //non ho fatto il login oppure qualcosa è andato storto
				$menu_form .= '   <a class="menuItem" href="login.php">Accedi</a>'."\n";
			}

			$menu_form .= '   <a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>'."\n";
			$menu_form .= '</div>'."\n";

			return $menu_form;
		}

		/**
		 * Funzione per settare il messaggio nella pagina vuota
		 * 
		 * @param string $messaggio string testo da visualizzare
		 * @param bool $errore indica se il messaggio è  un errore
		 * 
		 * @return string l'HTML della pagina
		 */
		public static function setMessaggio($messaggio, $errore){

			$class  = $errore ? "errorMessage" : "message";

			$output = file_get_contents("../HTML/paginaVuota.html");
			$output = str_replace("<messaggio></messaggio>","<p class='$class'>$messaggio</p>",$output);

			return $output;
		}
	}
?>
