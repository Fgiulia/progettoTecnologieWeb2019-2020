<?php
	class sqlInteractions {
#credenziali DB
    const host = 'localhost';
	const user = 'admin';
	const pass = 'admin';
	const dbName = 'Zoo';

#funzione per la connessione ad DB
	public function apriConnessioneDB(){
		$connection = "";
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
		$descAnimale = $_POST['descrizioneAnimale'];
		$immagine = "";
		$descImmagine = $_POST['descrizioneImmagine'];
		if(is_uploaded_file($_FILES["immagineAnimale"]["tmp_name"])){
			$destination = "../images/". basename($_FILES["immagineAnimale"]["name"]);
			if(move_uploaded_file($_FILES['immagineAnimale']["tmp_name"], $destination)){
				$immagine = "../images/". basename($_FILES["immagineAnimale"]["name"]);
			}
		}

		$insertAnimale = "INSERT INTO Animali() VALUES ('$nomeComune','$nomeProprio','$nomeScientifico','$famiglia','$sezione','$descAnimale','$immagine','$descImmagine')";
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
		$descrizione = $_POST['descrizioneEvento'];

		$prezzo = floatval($prezzo);

		$insertEvento = "INSERT INTO Eventi() VALUES ($nome','$prezzo','$data','$descrizione')";
		if ($this->connection->query($insertEvento) === TRUE){
			return true;
		}
		else{
			return false;
		}
	}

#funzione per la lettura da DB per la pagina "cuccioli"
	public function getCuccioli(){
		$query = 'SELECT NomeComune, NomeProprio, NomeScientifico, DescrizioneAnimale, Immagine, DescrizioneImmagine FROM Animali WHERE Famiglia=\'Cuccioli\' ORDER BY NomeComune ASC';
		$queryResult = mysqli_query($this->connection,$query);

		if(mysqli_num_rows($queryResult)==0){
			return null;
		}
		else{
			$result = array();
			while($row=mysqli_fetch_assoc($queryResult)){
				$arraySingoloCucciolo = array('NomeComune'=>$row['NomeComune'],'NomeProprio'=>$row['NomeProprio'],'NomeScientifico'=>$row['NomeScientifico'],'DescrizioneAnimale'=>$row['DescrizioneAnimale'],'Immagine'=>$row['Immagine'],'DescrizioneImmagine'=>$row['DescrizioneImmagine'],);
				array_push($result,$arraySingoloCucciolo);
			}
			return $result;
		}
	}

#funzione per la lettura da DB con filtri di ricerca
	public function getResultSearch() {
		$testo = $_POST['testo'];
        $famiglia = $_POST['scegliFamiglia'];
        $sezioneParco = $_POST['sezioneParco'];

		if($testo==null && $famiglia==null && $sezioneParco==null){
			$select = 'SELECT NomeComune, NomeScientifico, DescrizioneAnimale, Immagine, DescrizioneImmagine FROM Animali WHERE Famiglia!=\'Cuccioli\' ORDER BY NomeComune ASC';
		}
		else{
			#tutti i campi settati
			if($testo!=null && $famiglia!=null && $sezioneParco!=null){
				$select = 'SELECT NomeComune, NomeScientifico, DescrizioneAnimale, Immagine, DescrizioneImmagine FROM Animali WHERE (NomeComune LIKE \'%'.$testo.'%\' OR NomeScientifico LIKE \'%'.$testo.'%\') AND Famiglia=\''.$famiglia.'\' AND SezioneParco=\''.$sezioneParco.'\' ORDER BY NomeComune ASC';
			}
			#ricerca per famiglia e sezioneParco
			if($testo==null && $famiglia!=null && $sezioneParco!=null){
				$select = 'SELECT NomeComune, NomeScientifico, DescrizioneAnimale, Immagine, DescrizioneImmagine FROM Animali WHERE Famiglia=\''.$famiglia.'\' AND SezioneParco=\''.$sezioneParco.'\' ORDER BY NomeComune ASC';
			}
			#ricerca per testo e sezioneParco
			if($testo!=null && $famiglia==null && $sezioneParco!=null){
				$select = 'SELECT NomeComune, NomeScientifico, DescrizioneAnimale, Immagine, DescrizioneImmagine FROM Animali WHERE (NomeComune LIKE \'%'.$testo.'%\' OR NomeScientifico LIKE \'%'.$testo.'%\') AND Famiglia!=\'Cuccioli\' AND SezioneParco=\''.$sezioneParco.'\' ORDER BY NomeComune ASC';
			}
			#ricerca per testo e famiglia
			if($testo!=null && $famiglia!=null && $sezioneParco==null){
				$select = 'SELECT NomeComune, NomeScientifico, DescrizioneAnimale, Immagine, DescrizioneImmagine FROM Animali WHERE (NomeComune LIKE \'%'.$testo.'%\' OR NomeScientifico LIKE \'%'.$testo.'%\') AND Famiglia=\''.$famiglia.'\' ORDER BY NomeComune ASC';
			}
			#ricerca per solo testo in input
			if($testo!=null && $famiglia==null && $sezioneParco==null){
				$select = 'SELECT NomeComune, NomeScientifico, DescrizioneAnimale, Immagine, DescrizioneImmagine FROM Animali WHERE NomeComune LIKE \'%'.$testo.'%\' OR NomeScientifico LIKE \'%'.$testo.'%\' AND Famiglia!=\'Cuccioli\' ORDER BY NomeComune ASC';
			}
			#ricerca per solo campo famiglia
			if($testo==null && $famiglia!=null && $sezioneParco==null){
				$select = 'SELECT NomeComune, NomeScientifico, DescrizioneAnimale, Immagine, DescrizioneImmagine FROM Animali WHERE Famiglia=\''.$famiglia.'\' ORDER BY NomeComune ASC';
			}
			#ricerca per solo campo sezioneParco
			if($testo==null && $famiglia==null && $sezioneParco!=null){
				$select = 'SELECT NomeComune, NomeScientifico, DescrizioneAnimale, Immagine, DescrizioneImmagine FROM Animali WHERE Famiglia!=\'Cuccioli\' AND SezioneParco=\''.$sezioneParco.'\' ORDER BY NomeComune ASC';
			}
		}
		$selectResult = mysqli_query($this->connection,$select);

		if(mysqli_num_rows($selectResult)==0){
			return null;
		}
		else{
			$animali = array();
			while($row=mysqli_fetch_assoc($selectResult)){
				$arraySingoloAnimale = array('NomeComune'=>$row['NomeComune'],'NomeScientifico'=>$row['NomeScientifico'],'DescrizioneAnimale'=>$row['DescrizioneAnimale'],'Immagine'=>$row['Immagine'],'DescrizioneImmagine'=>$row['DescrizioneImmagine']);
				array_push($animali,$arraySingoloAnimale);
			}
			return $animali;
		}
	}

#funzione per la lettura da DB del prossimo evento (per la homepage)
	public function getEventi(){
		$data = date("YYYY-mm-dd");
		$selectEvents = 'SELECT Nome, Prezzo, Data, Descrizione FROM Eventi WHERE Data=\''.$data.'\' OR Data>\''.$data.'\' ORDER BY Data ASC LIMIT 1';
		$selectEventsResult = mysqli_query($this->connection,$selectEvents);
		$eventi = array();

		if(mysqli_num_rows($selectEventsResult)==0){
			return null;
		}
		else{
			while($row=mysqli_fetch_assoc($selectEventsResult)){
				$arraySingoloEvento = array('Nome'=>$row['Nome'],'Prezzo'=>$row['Prezzo'],'Data'=>$row['Data'],'Descrizione'=>$row['Descrizione']);
				array_push($eventi,$arraySingoloEvento);
			}
			return $eventi;
		}
	}

	#semplice select per la lettura da DB di tutti gli eventi disponibili da oggi
	public function getAllEventiFromToday(){
		$data = date("Ymd");
		$selectEventi = 'SELECT Nome, Prezzo, Data FROM Eventi WHERE Data>\''.$data.'\'';
		$selectEventiResult = mysqli_query($this->connection,$selectEventi);
		$eventi = array();
		
		if(mysqli_num_rows($selectEventiResult)==0){
			return null;
		}
		else{
			while($row=mysqli_fetch_assoc($selectEventiResult)){
				$singoloEvento = array('Nome'=>$row['Nome'],'Prezzo'=>$row['Prezzo'],'Data'=>$row['Data']);
				array_push($eventi,$singoloEvento);
			}
			return $eventi;
		}
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
