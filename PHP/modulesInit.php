<?php
	class modulesInit{
		#funzione controllo input validi
		public function validName($name){
			if(!empty($name)){
				if(preg_match("/^[a-zA-Z ]*$/",$name)){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}

		public function validDescription($testo){
			if(!empty($testo)){
				if(strlen("$testo")<=1200){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}

		public function validImage($immagine){
			if(getimagesize($immagine)){
				return true;
			}
			else{
				return false;
			}
		}

		public function validDate(){}

		public function validEmail(){}

		public function validPhone(){}

		public function validPrice(){}

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
						.'	  <a class="dropbtn" href="animali.php">Animali'."\n"
						.'		 <i class="fa fa-caret-down"></i>'."\n"
						.'	  </a>'."\n"
						.'	  <div class="dropdown-content">'."\n"
						.'		  <a href="animali.php">Tutti gli animali</a>'."\n"
						.'		  <a href="cuccioli.php">I cuccioli</a>'."\n"
						.'	  </div>'."\n"
						.'  </div>'."\n"
						.'  <a class="menuItem" href="eventi.php">Eventi</a>'."\n"
						.'  <div class="dropdown menuItem">'."\n"
						.'	  <a href="info.php" class="dropbtn">Informazioni'."\n"
						.'		 <i class="fa fa-caret-down"></i>'."\n"
						.'	  </a>'."\n"
						.'	  <div class="dropdown-content">'."\n"
						.'		  <a href="info.php#contatti">Contatti</a>'."\n"
						.'	  </div>'."\n"
						.'  </div>'."\n"
						.'  <a class="menuItem" href="acquista.php">Acquista</a>'."\n";

			#gestione di accedi area personale
			if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) { //login effettuato correttamente

				if($_SESSION['admin'] == 1) { //Sono l'admin
					$menu_form .= '<a class="menuItem" href="areaPrivata.php?pageName=principale">Pannello Amministratore</a>'."\n";
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

			if(!isset($_SESSION))
				session_start();
			
			$user = $_SESSION["user"];
			
			$sql = "SELECT CONCAT(Nome, ' ', Cognome) AS Utente, NumGratis, NumRidotti, NumInteri, Data
					FROM `BigliettiUtenti`
					LEFT JOIN Utenti ON `Utente` = Utenti.Email";

			if($_SESSION["admin"] == 0) {
				$sql .= " WHERE BigliettiUtenti.Utente = ? ";
			}

			global $dbh; // rendo visibile $dbh dichiarato nel file config.php

			$query = query($dbh, $sql, [$user]);
			$output = "";
			if($query->status) {

				if(count($query->rows) == 0)
					return "<h3>Non ci sono biglietti da visualizzare</h3>";

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

			if(!isset($_SESSION))
				session_start();
			
			$sql = "SELECT CONCAT(Utenti.Nome, ' ', Cognome) AS Utente, Eventi.Nome as Evento, Prezzo, EventiUtenti.Data as DataAcquisto, NumeroPersone
					FROM `EventiUtenti`
					LEFT JOIN Utenti ON `Utente` = Utenti.Email
					LEFT JOIN Eventi ON IDEvento = Eventi.ID";

			global $dbh; // rendo visibile $dbh dichiarato nel file config.php

			if(!isset($_SESSION))
				session_start();

			if($_SESSION["admin"] == 0) {
				$sql .= " WHERE EventiUtenti.Utente = ? ";
			}

			$user = $_SESSION["user"];

			$query = query($dbh, $sql, [$user]);
			$output = "";
			if($query->status) {

				if($query->rowCount == 0)
					return "<h3>Non ci sono eventi da visualizzare</h3>";
				
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

		/**
		* Funzione per la creazione della lista degli animali dell'area privata
		* 
		* @return string l'HTML della pagina
		*/
		public static function getAnimali() {

			if(!isset($_SESSION))
				session_start();

			$query = find("AnimaleBean", null);
			$output = "";
			if($query->status) {

				if(count($query->response) == 0)
					return "<h3>Non ci sono animali da visualizzare</h3>";

				foreach($query->response as $row) {

					$output .= '<div class="acquisto">'."\n";

					$output .= "	<img class='logoHeader' src='".$row->Ritratto."' alt='immagine animale' />"."\n"
								.'	<div>'."\n"
								.'		<h4>Nome</h4>'."\n"
								.'		<p>'.$row->NomeComune.'</p>'."\n"
								.'	</div>'."\n"
								.'	<div>'."\n"
								.'		<h4>Nome scientifico</h4>'."\n"
								.'		<p>'.$row->NomeScientifico.'</p>'."\n"
								.'	</div>'."\n"
								.'	<div>'."\n"
								.'	<form action="../PHP/eliminaAnimale.php" method="post">'."\n"
								.'		<button type="submit" name="eliminaAnimale" value="'.$row->NomeComune.'" class="button internal-button">Elimina</button>'."\n"
								.'	</form>'."\n"
								.'	</div>'."\n"
								.'</div>';
				}
			} else {
				$output = "Errore: ".$query->response;
			}

			return $output;
		}

		/**
		* Funzione per la creazione della lista dei messaggi dell'area privata
		* 
		* @return string l'HTML della pagina
		*/
		public static function getMessaggi() {

			if(!isset($_SESSION))
				session_start();

			$model = null;

			if($_SESSION["admin"] == 0) {
				$model = (Object) [
					"Email" => $_SESSION["user"]
				];
			}

			$query = find("MessaggioBean", $model);
			$output = "";
			if($query->status) {

				if(count($query->response) == 0)
					return "<h3>Non ci sono messaggi da visualizzare</h3>";

				foreach($query->response as $row) {

					$output .= '<div class="acquisto">'."\n";

					if($_SESSION['admin'] == 1) {

						$output .= '	<div>'."\n"
									.'		<h4>Utente</h4>'."\n"
									.'		<p>'.$row->Nome.' '.$row->Cognome.'</p>'."\n"
									.'	</div>'."\n"
									.'	<div>'."\n"
									.'		<h4>Email</h4>'."\n"
									.'		<p>'.$row->Email.'</p>'."\n"
									.'	</div>'."\n";
					}

					$output .=  '	<div class="testoMessaggio">'."\n"
								.'		<h4>Messaggio</h4>'."\n"
								.'		<p>'.$row->Messaggio.'</p>'."\n"
								.'	</div>'."\n";

					if($_SESSION["admin"] == 1) {			
						$output .= '<form action="" method="post">'."\n"
								.'		<button type="submit" name="risposta" value="'.$row->ID.'" class="button internal-button">Rispondi</button>'."\n"
								.'	</form>'."\n";
					}

					$output .= '</div>';
				}
			} else {
				$output = "Errore: ".$query->response;
			}

			return $output;
		}

		/**
		* Funzione per la creazione della lista degli eventi dell'area privata
		* 
		* @return string l'HTML della pagina
		*/
		public static function getEventi() {

			if(!isset($_SESSION))
				session_start();

			$query = find("EventoBean", null);
			$output = "";
			if($query->status) {

				if(count($query->response) == 0)
					return "<h3>Non ci sono eventi da visualizzare</h3>";

				foreach($query->response as $row) {

					$output .= '<div class="acquisto">'."\n";

					$time = strtotime($row->Data);
					$dateInLocal = date("d-m-Y", $time);

					$output .=	'	<div>'."\n"
								.'		<h4>Nome evento</h4>'."\n"
								.'		<p>'.$row->Nome.'</p>'."\n"
								.'	</div>'."\n"
								.'	<div>'."\n"
								.'		<h4>Data evento</h4>'."\n"
								.'		<p>'.$dateInLocal.'</p>'."\n"
								.'	</div>'."\n"
								.'	<div>'."\n"
								.'	<form action="../PHP/eliminaEvento.php" method="post">'."\n"
								.'		<button type="submit" name="eliminaEvento" value="'.$row->ID.'" class="button internal-button">Elimina</button>'."\n"
								.'	</form>'."\n"
								.'	</div>'."\n"
								.'</div>';
				}
			} else {
				$output = "Errore: ".$query->response;
			}

			return $output;
		}
	}
?>
