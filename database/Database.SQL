CREATE DATABASE Zoo;

CREATE TABLE IF NOT EXISTS Utenti (
    Email varchar(30),
    Password varchar(20),
    Nome varchar(50),
    Cognome varchar(50),
    PRIMARY KEY(Username)
);

CREATE TABLE IF NOT EXISTS Prezzi (
    Tipo varchar(20),
    Prezzo decimal(3,2),
    PRIMARY KEY(Tipo)
);
/*
CREATE TABLE IF NOT EXISTS Eventi (
    ID int AUTO_INCREMENT,
    Utente varchar(20),
    Gratis int(2),
    Ridotto int(2),
    Intero int(2),
    PRIMARY KEY(ID)
);
*/

CREATE TABLE IF NOT EXISTS PrenotazioneBiglietti (
    ID int AUTO_INCREMENT,
    Utente varchar(20),
    Gratis int(2),
    Ridotto int(2),
    Intero int(2),
    PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS PrenotazioneEventi (
    ID int AUTO_INCREMENT,
    Utente varchar(20),
    Gratis int(2),
    Ridotto int(2),
    Intero int(2),
    PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS Animali (
    NomeComune varchar(20),
    NomeScientifico varchar(50),
    Ordine varchar(20),
    Famiglia varchar(20),
    Descrizione varchar(250),
    PRIMARY KEY(NomeComune)
);

ALTER TABLE Prenotazioni
ADD CONSTRAINT FK_utenti FOREIGN KEY (Utente)
REFERENCES Utenti(Username)
ON DELETE CASCADE ON UPDATE CASCADE;