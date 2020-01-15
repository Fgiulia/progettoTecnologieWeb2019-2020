<?php
	class modulesInit{
		#funzione per scrivere i breadcrumb
		public static function breadcrumb(...$sequenza){
			$breadcrumb = "Ti trovi in&colon; ";
			foreach($sequenza as $element){
				$breadcrumb .= "$element ";
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
						.'	  <a class="dropbtn" href="">Animali</a>'."\n"
						.'	  <div class="dropdown-content">'."\n"
						.'		  <a href="animali.php">Tutti gli animali</a>'."\n"
						.'		  <a href="cuccioli.php">I cuccioli</a>'."\n"
						.'	  </div>'."\n"
						.'  </div>'."\n"
						.'  <a class="menuItem" href="eventi.php">Eventi</a>'."\n"
						.'  <div class="dropdown menuItem">'."\n"
						.'	  <a href="info.php" class="dropbtn">Informazioni</a>'."\n"
						.'	  <div class="dropdown-content">'."\n"
						.'		  <a href="info.php#contatti">Contattaci</a>'."\n"
						.'	  </div>'."\n"
						.'  </div>'."\n"
						.'  <a class="menuItem" href="acquista.php">Acquista</a>'."\n";

			#gestione di accedi area personale
			if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) { //login effettuato correttamente

				if($_SESSION['admin'] == 1) { //Sono l'admin
					$menu_form .= '<a class="menuItem" href="areaPrivata.php?pageName=principale">Pannello Amministrativo</a>'."\n";
				} else {
					$menu_form .= '<a class="menuItem" href="areaPrivata.php?pageName=principale">Area Personale</a>'."\n";
				}

				$menu_form .= '<a class="menuItem" href="../PHP/login/logout.php">Logout</a>'."\n";
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

			$class  = $errore ? "errorMessage" : "messaggio";

			$output = file_get_contents("../HTML/paginaVuota.html");
			$output = str_replace("<messaggio></messaggio>","<p class='$class'>$messaggio</p>",$output);

			return $output;
		}

		/**
		 * Funzione per la creazione della lista dei biglietti acquistati
		 * 
		 * @return string l'HTML della pagina
		 */
		public static function bigliettiAcquistati(){

			$utente = "";
			$data = "";
			$biglietti = "";
			
			$sql = "SELECT CONCAT(Nome, ' ', Cognome) AS Utente, NumGratis, NumRidotti, NumInteri, Data
					FROM `BigliettiUtenti`
					LEFT JOIN Utenti ON `Utente` = Utenti.Email";

			global $dbh; // rendo visibile $dbh dichiarato nel file config.php

			$query = query($dbh, $sql, null);
			$output = "";
			if($query->status) {
				foreach($query->rows as $row) {

					$output .= '<div class="acquisto">'."\n";

					if($_SESSION['admin'] == 1) {
						$output .= '	<div>'."\n"
									.'		<h4>Utente</h4>'."\n"
									.'		<p>'.$row->Utente.'</p>'."\n"
									.'	</div>'."\n";
					}

					$output .= '	<div>'."\n"
								.'		<h4>Data acquisto</h4>'."\n"
								.'		<p>'.$row->Data.'</p>'."\n"
								.'	</div>'."\n"
								.'  <div>'."\n"
								.'		<h4>Biglietti acquistati</h4>'."\n"
								.'		<ul>'."\n"
								.'			<li>'.$row->NumGratis.' biglietti gratuiti</li>'."\n"
								.'			<li>'.$row->NumRidotti.' biglietti ridotti</li>'."\n"
								.'			<li>'.$row->NumInteri.' biglietti interi</li>'."\n"
								.'		</ul>'."\n"
								.'	</div>'."\n"
								.'</div>';
				}
			} else {
				$output = "Errore: ".$query->error;
			}

			return $output;
		}

		/**
		 * Funzione per la creazione della lista dei eventi acquistati
		 * 
		 * @return string l'HTML della pagina
		 */
		public static function eventiPrenotati(){

			$utente = "";
			$data = "";
			$biglietti = "";
			
			$sql = "SELECT CONCAT(Utenti.Nome, ' ', Cognome) AS Utente, Eventi.Nome as Evento, Prezzo, EventiUtenti.Data as DataAcquisto, NumeroPersone
					FROM `EventiUtenti`
					LEFT JOIN Utenti ON `Utente` = Utenti.Email
					LEFT JOIN Eventi ON IDEvento = Eventi.ID";

			global $dbh; // rendo visibile $dbh dichiarato nel file config.php

			$query = query($dbh, $sql, null);
			$output = "";
			if($query->status) {
				foreach($query->rows as $row) {

					$output .= '<div class="acquisto">'."\n";

					if($_SESSION['admin'] == 1) {
						$output .= '	<div>'."\n"
									.'		<h4>Utente</h4>'."\n"
									.'		<p>'.$row->Utente.'</p>'."\n"
									.'	</div>'."\n";
					}

					$output .= '	<div>'."\n"
								.'		<h4>Evento</h4>'."\n"
								.'		<p>'.$row->Evento.'</p>'."\n"
								.'	</div>'."\n"
								.'  <div>'."\n"
								.'		<h4>Dati acquisto</h4>'."\n"
								.'		<ul>'."\n"
								.'			<li>Data: '.$row->DataAcquisto.'</li>'."\n"
								.'			<li>'.$row->NumeroPersone.' persone</li>'."\n"
								.'			<li>Prezzo: € '.$row->Prezzo.'</li>'."\n"
								.'		</ul>'."\n"
								.'	</div>'."\n"
								.'</div>';
				}
			} else {
				$output = "Errore: ".$query->error;
			}

			return $output;
		}
	}
?>
