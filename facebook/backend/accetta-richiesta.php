<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();



$mittente = $_POST["mittente"];
$destinatario = $_POST["destinatario"];


$ris = accettaRichiestaAmicizia($cid, $mittente, $destinatario);

$errore = $ris["tipoErrore"];
$dati = $ris["contenuto"];

if ($ris["status"]=='ok'){
        $_SESSION["status"] = "ok";
        $_SESSION["logged"] = true;
        $location="../frontend/risultati-ricerca.php";
}
else{	        
        $_SESSION["status"] = "ko";
		$location="../frontend/risultati-ricerca.php";
        header("location:$location.php?status=ko&errore=".serialize($errore)."&dati=".serialize($dati)); 
}
