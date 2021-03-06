CREATE TABLE IF NOT EXISTS Utenti (
    Email varchar(50),
    Password varchar(100),
    Nome varchar(50),
    Cognome varchar(50),
    Telefono varchar(15),
    Indirizzo varchar(100),
    DataNascita date,
    FlAdmin boolean,
    PRIMARY KEY(Email)
);

CREATE TABLE IF NOT EXISTS Biglietti (
    Tipo varchar(20),
    Prezzo decimal(5,2),
    PRIMARY KEY(Tipo)
);

CREATE TABLE IF NOT EXISTS Eventi (
    ID int(11) AUTO_INCREMENT,
    Nome varchar(50),
    Prezzo decimal(5,2),
    Data date,
    Descrizione text,
    PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS BigliettiUtenti (
    NumeroOrdine int AUTO_INCREMENT,
    Utente varchar(50),
    NumGratis int(2),
    NumRidotti int(2),
    NumInteri int(2),
    Data date,
    PRIMARY KEY(NumeroOrdine)
);

CREATE TABLE IF NOT EXISTS EventiUtenti (
    NumeroPrenotazione int AUTO_INCREMENT,
    Utente varchar(50),
    NumeroPersone int(2),
    IDEvento int(11),
    Data date,
    PRIMARY KEY(NumeroPrenotazione)
);

CREATE TABLE IF NOT EXISTS Animali (
    NomeComune varchar(30),
    NomeProprio varchar(20) NULL,
    NomeScientifico varchar(50),
    Famiglia varchar(20),
    SezioneParco varchar(20),
    DescrizioneAnimale text,
    Immagine text NULL,
    DescrizioneImmagine text NULL,
    PRIMARY KEY(NomeComune,Famiglia)
);

CREATE TABLE IF NOT EXISTS Messaggi (
    ID int AUTO_INCREMENT,
    Nome varchar(30),
    Cognome varchar(30),
    Email varchar(50),
    NumeroTelefono varchar(10),
    Messaggio text,
    PRIMARY KEY(ID)
);

ALTER TABLE EventiUtenti
ADD CONSTRAINT FK_eventoUtenti FOREIGN KEY (Utente)
REFERENCES Utenti(Email)
ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE EventiUtenti
ADD CONSTRAINT FK_IDEvento FOREIGN KEY (IDEvento)
REFERENCES Eventi(ID)
ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE BigliettiUtenti
ADD CONSTRAINT FK_bigliettiUtenti FOREIGN KEY (Utente)
REFERENCES Utenti(Email)
ON DELETE SET NULL ON UPDATE CASCADE;

