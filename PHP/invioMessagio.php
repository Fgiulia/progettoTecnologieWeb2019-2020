<?php

$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$email = $_POST["email"];
$telefono = $_POST["numerotelefono"];
$messaggio = $_POST["messaggio"]

$oggettoPagina = new sqlInteractions();
$connessione = $oggettoPagina->apriConnessioneDB();

if($connessione)
{
    




}
