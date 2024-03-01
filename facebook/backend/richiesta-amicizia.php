<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();



$mittente = $_POST["mittente"];
$destinatario = $_POST["destinatario"];


$ris = inviaRichiestaAmicizia($cid, $mittente, $destinatario);

$errore = $ris["tipoErrore"];
$dati = $ris["contenuto"];


