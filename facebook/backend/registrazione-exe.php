<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();

$ris= inserisciUtente($cid, $_POST["email"], $_POST["pwd"],$_POST["confirmPwd"],$_POST["nome"],$_POST["cognome"],$_POST["dataN"],$_POST["cittaN"],$_POST["provinciaN"],$_POST["statoN"],$_POST["cittaR"],$_POST["provinciaR"],$_POST["statoR"]);
$errore = $ris["tipoErrore"];
$dati = $ris["contenuto"];
$login = $_POST["email"];
$pwd = $_POST["pwd"];
$ris2 = isUser($cid,$login,$pwd);
if (($ris["status"]=='ok') And ($ris2["status"]=='ok')) {
		$_SESSION["utente"]=$login;
        $_SESSION["status"] = "ok";
        $_SESSION["logged"] = true;
        $location="../frontend/home-page";
		header("location:$location.php?status=ok&!errore=".serialize($errore)."&dati=".serialize($dati)); 
}
else{	        
        $_SESSION["status"] = "ko";
		$location="../frontend/registrazione";
        header("location:$location.php?status=ko&errore=".serialize($errore)."&dati=".serialize($dati)); 
}
