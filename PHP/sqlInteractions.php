<?php
	class sqlInteractions {
#credenziali DB
    const host = 'localhost';
	const user = 'admin';
	const pass = 'admin';
	const dbName = 'Zoo';
#inizializzazione di variabili
	public $connection = null;
	public $testo = null;
    public $famiglia = null;
    
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
    
#funzione per la lettura da DB dei cuccioli
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

#funzione per la lettura da DB con passaggio del nome (ricerca da input)
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

#funzione per la lettura da DB con passaggio della famiglia (menu a tendina)
    public function getFamily($famiglia) {
        if($famiglia==null || $famiglia=='animali'){
            $family = 'SELECT NomeComune, NomeScientifico, Ritratto, Descrizione FROM Animali WHERE Famiglia!=\'Cuccioli\' ORDER BY NomeComune ASC';
        }
        else{
			$family = 'SELECT NomeComune, NomeScientifico, Ritratto, Descrizione FROM Animali WHERE Famiglia=\''.$famiglia.'\' ORDER BY NomeComune ASC';
        }
        $familyResult = mysqli_query($this->connection,$family);

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
}

?>
