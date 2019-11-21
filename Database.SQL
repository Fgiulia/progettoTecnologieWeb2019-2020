CREATE DATABASE Zoo;

CREATE TABLE IF NOT EXISTS Utenti (
    Username varchar(20),
    Password varchar(20),
    Nome varchar(50),
    Cognome varchar(50),
    Email varchar(30),
    PRIMARY KEY(Username)
);

CREATE TABLE IF NOT EXISTS Prezzi (
    Tipo varchar(20),
    Prezzo decimal(3,2),
    PRIMARY KEY(Tipo)
);

CREATE TABLE IF NOT EXISTS Prenotazioni (
    ID int AUTO_INCREMENT,
    Utente varchar(20),
    Gratis int(2),
    Ridotto int(2),
    Intero int(2),
    PRIMARY KEY(ID)
);

ALTER TABLE Prenotazioni
ADD CONSTRAINT FK_utenti FOREIGN KEY (Utente)
REFERENCES Utenti(Username)
ON DELETE CASCADE ON UPDATE CASCADE;