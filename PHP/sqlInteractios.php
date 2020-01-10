<?php

class sqlInteractions{
#credenziali DB
    const host = '';
	const user = '';
	const pass = '';
	const dbName ='';
#inizializzazione di variabilI
    public $connection=null;
    public $famiglia=null;
    
#funzione per la connessione ad DB	
	public function apriConnessioneDB() {
		$this->connection=mysqli_connect(static::host,static::user,static::pass,static::dbName);
		if(!$this->connection) {//se la connessione non avviene
			return false;
		}
		else {//se la connessione avviene
			return true;
		}
	}
    
#funzione per la lettura da DB dei cuccioli
	public function getCuccioli() {
		$query='SELECT NomeComune,NomeProprio FROM Animali WHERE Famiglia=\'Cuccioli\' ORDER BY NomeComune ASC'; //query SQL
		$queryResult=mysqli_query($this->connection,$query);
		
		if(mysqli_num_rows($queryResult)==0){ //mysqli_num_row restituisce il numero di righe ottenute dalla query
			return null;
		}
		else {
			$result=array();
			while($row=mysqli_fetch_assoc($queryResult)){ //finche' ci sono risultati nella query
				$arraySingoloCucciolo=array('NomeComune'=>$row['NomeComune'],'NomeProprio'=>$row['NomeProprio']); //contine un singolo risultato della query (un solo cucciolo)
				array_push($result,$arraySingoloCucciolo); //la funzione inserisce nell'array al primo parametro cio' che e' contenuto nel secondo parametro
			}
			return $result; //viene restituito un array associativo con in ogni riga un cucciolo con tutte le sue informazioni
		}
	}

#funzione per la lettura da DB con passaggio della famiglia (menu a tendina)
    public function getSelect($famiglia) {
        if($famiglia==null){
            $select='SELECT * FROM Animali WHERE Famiglia!=\'Cuccioli\' ORDER BY NomeComune ASC';
        }
        else{
            if($famiglia=='Mammiferi'){
                $select='SELECT * FROM Animali WHERE Famiglia=\'Mammiferi\' ORDER BY NomeComune ASC';
            }
            if($famiglia=='Rettili'){
                $select='SELECT * FROM Animali WHERE Famiglia=\'Rettili\' ORDER BY NomeComune ASC';
            }
            if($famiglia=='Uccelli'){
                $select='SELECT * FROM Animali WHERE Famiglia=\'Uccelli\' ORDER BY NomeComune ASC';
            }
        }
        $selectResult=mysqli_query($this->connection,$select);

        if(mysqli_num_rows($selectResult)==0){ //mysqli_num_row restituisce il numero di righe ottenute dalla query
			return null;
		}
		else{
			$animal=array();
			while($row=mysqli_fetch_assoc($selectResult)){ //finche' ci sono risultati nella query
				$arraySingoloAnimale=array('NomeComune'=>$row['NomeComune']); //contine un singolo risultato della query (un solo animale)
				array_push($animal,$arraySingoloAnimale); //la funzione inserisce nell'array al primo parametro cio' che e' contenuto nel secondo parametro
			}
            return $animal;
        }
    }
}

?>
