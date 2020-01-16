<?php
	class sqlInteractions {
#credenziali DB
    const host = 'localhost';
	const user = 'admin';
	const pass = 'admin';
	const dbName = 'zoo';
#inizializzazione di variabili
	public $connection = null;
	public $testo = null;
    public $sezioneParco = null;
    
#funzione per la connessione ad DB	
	public function apriConnessioneDB(){
		$this->connection = mysqli_connect(static::host,static::user,static::pass,static::dbName);
		if(!$this->connection){
			return false;
		}
		else{
			return true;
		}
	}

#funzione per l'inserimento nel DB di un nuovo animale
	public function insertAnimal(){
		$nomeComune = $_POST['nomeComune'];
		$nomeProprio = $_POST['nomeProprio'];
		$nomeScientifico = $_POST['nomeScientifico'];
		$famiglia = $_POST['famiglia'];
		$sezione = $_POST['sezioneParco'];
		$descrizione = $_POST['descrizione'];
		$ritratto = $_POST['immagineAnimale'];

		$insertAnimale = "INSERT INTO Animali() VALUES ('$nomeComune','$nomeProprio','$nomeScientifico','$famiglia','$sezione','$descrizione','$ritratto')";
		if ($this->connection->query($insertAnimale) === TRUE){
			return true;
		}
		else{
			return false;
		}
	}

#funzione per l'inserimento nel DB di un nuovo messaggio
	public function insertMessage(){
		$nome = $_POST['nome'];
		$cognome = $_POST['cognome'];
		$email = $_POST['email'];
		$numTel = $_POST['numeroTelefono'];
		$messaggio = $_POST['messaggio'];

		$insertMessaggio = "INSERT INTO Messaggi() VALUES ('$nome','$cognome','$email','$numTel','$messaggio')";
		if ($this->connection->query($insertMessaggio) === TRUE){
			return true;
		}
		else{
			return false;
		}
	}

#funzione per l'inserimento nel DB di un nuovo evento
	public function insertEvent(){
		$nome = $_POST['nome'];
		$prezzo = $_POST['prezzo'];
		$data = $_POST['data'];
		$giorno = $_POST['giorno'];

		$insertEvento = "INSERT INTO Eventi() VALUES ('$nome','$prezzo','$data','$giorno')";
		if ($this->connection->query($insertEvento) === TRUE){
			return true;
		}
		else{
			return false;
		}
	}

#funzione per la lettura da DB dela pagina "cuccioli"
	public function getCuccioli(){
		$query = 'SELECT NomeComune, NomeProprio, Ritratto, Descrizione FROM Animali WHERE Famiglia=\'Cuccioli\' ORDER BY NomeComune ASC';
		$queryResult = mysqli_query($this->connection,$query);

		if(mysqli_num_rows($queryResult)==0){
			return null;
		}
		else{
			$result = array();
			while($row=mysqli_fetch_assoc($queryResult)){
				$arraySingoloCucciolo = array('NomeComune'=>$row['NomeComune'],'NomeProprio'=>$row['NomeProprio'],'Ritratto'=>$row['Ritratto'],'Descrizione'=>$row['Descrizione']);
				array_push($result,$arraySingoloCucciolo);
			}
			return $result;
		}
	}

#funzione per la lettura da DB con testo in input (ricerca per parole-chiave)
	public function getSelect($testo) {
		if($testo==null){
			$select = 'SELECT NomeComune, NomeScientifico, Ritratto, Descrizione FROM Animali WHERE Famiglia!=\'Cuccioli\' ORDER BY NomeComune ASC';
		}
		else{
			$select = 'SELECT NomeComune, NomeScientifico, Ritratto, Descrizione FROM Animali WHERE NomeComune LIKE \'%'.$testo.'%\' OR NomeScientifico LIKE \'%'.$testo.'%\' OR Famiglia LIKE \'%'.$testo.'%\' OR SezioneParco LIKE \'%'.$testo.'%\' ORDER BY NomeComune ASC';
		}
		$selectResult = mysqli_query($this->connection,$select);

		if(mysqli_num_rows($selectResult)==0){
			return null;
		}
		else{
			$animal = array();
			while($row=mysqli_fetch_assoc($selectResult)){
				$arraySingoloAnimale = array('NomeComune'=>$row['NomeComune'],'NomeScientifico'=>$row['NomeScientifico'],'Ritratto'=>$row['Ritratto'],'Descrizione'=>$row['Descrizione']);
				array_push($animal,$arraySingoloAnimale);
			}
			return $animal;
		}
	}

#funzione per la lettura da DB con passaggio della famiglia (ricerca da menu a tendina)
    public function getFamily($sezioneParco) {
        if($sezioneParco==null || $sezioneParco=='animali'){
            $section = 'SELECT NomeComune, NomeScientifico, Ritratto, Descrizione FROM Animali WHERE Famiglia!=\'Cuccioli\' ORDER BY NomeComune ASC';
        }
        else{
			$section = 'SELECT NomeComune, NomeScientifico, Ritratto, Descrizione FROM Animali WHERE Famiglia=\''.$sezioneParco.'\' ORDER BY NomeComune ASC';
        }
        $familyResult = mysqli_query($this->connection,$section);

        if(mysqli_num_rows($familyResult)==0){
			return null;
		}
		else{
			$animale = array();
			while($row=mysqli_fetch_assoc($familyResult)){
				$arrayAnimaleSingolo = array('NomeComune'=>$row['NomeComune'],'NomeScientifico'=>$row['NomeScientifico'],'Ritratto'=>$row['Ritratto'],'Descrizione'=>$row['Descrizione']);
				array_push($animale,$arrayAnimaleSingolo);
			}
            return $animale;
        }
	}

#funzione per la lettura da DB con passaggio della sezione del parco (ricerca da menu a tendina)
public function getSectionPark($sezioneParco) {
	if($sezioneParco==null){
		$section = 'SELECT NomeComune, NomeScientifico, Ritratto, Descrizione FROM Animali WHERE Famiglia!=\'Cuccioli\' ORDER BY NomeComune ASC';
	}
	else{
		$section = 'SELECT NomeComune, NomeScientifico, Ritratto, Descrizione FROM Animali WHERE SezioneParco=\''.$sezioneParco.'\' ORDER BY NomeComune ASC';
	}
	$sectionResult = mysqli_query($this->connection,$section);

	if(mysqli_num_rows($sectionResult)==0){
		return null;
	}
	else{
		$animale = array();
		while($row=mysqli_fetch_assoc($sectionResult)){
			$arrayAnimaleSingolo = array('NomeComune'=>$row['NomeComune'],'NomeScientifico'=>$row['NomeScientifico'],'Ritratto'=>$row['Ritratto'],'Descrizione'=>$row['Descrizione']);
			array_push($animale,$arrayAnimaleSingolo);
		}
		return $animale;
	}
}

#funzione per la lettura da DB dei prossimi (max 2) eventi
	public function getEventi(){
#		if(){}
		return ;
	}

	
   /**
	 * Funzione per la lettura da DB degli acquisti
	 * 
	 * @param String $user l'email dell'utente di cui si vogliono gli acuisti. Se passato null ritorna tutti gli acquisti
	 * 
	 * @return Array di oggetti che rappresentano un record della query
	*/
	public function getAcquisti($user) {
		$sql = "SELECT CONCAT(Nome, ' ', Cognome) AS Utente, NumGratis, NumRidotti, NumInteri, Data
				FROM `BigliettiUtenti`
				LEFT JOIN Utenti ON `Utente` = Utenti.Email ";
		
		if(isset($user)) {
			$sql .= "WHERE Utente = $user";
		}

		$result = mysqli_query($this->connection,$sql);

		if(mysqli_num_rows($result)==0){
			return null;
		}
		else{
			$acquisti = array();
			while($row=mysqli_fetch_assoc($result)){
				$item = (Object) [
					"Utente" => $row['Utente']
					,"NumGratis" => $row['NumGratis']
					,"NumRidotti" => $row['NumRidotti']
					,"NumInteri" => $row['NumInteri']
					,"Data" => $row['Data']
				];
				array_push($acquisti,$item);
			}
            return $acquisti;
        }
	}
}

?>
