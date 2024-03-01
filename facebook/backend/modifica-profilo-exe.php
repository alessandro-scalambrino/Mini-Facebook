<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();

$Nome = $_POST['Nome'];
$Cognome = $_POST['Cognome'];
$dataN = $_POST['dataN'];
$orientamento = $_POST['orientamento'];

// Informazioni di residenza
$cittaR = $_POST['cittaR'];
$provinciaR = $_POST['provinciaR'];
$statoR = $_POST['statoR'];

// Informazioni di nascita
$cittaN = $_POST['cittaN'];
$provinciaN = $_POST['provinciaN'];
$statoN = $_POST['statoN'];

// Informazioni di accesso
$email = $_POST['email'];
$password = $_POST['pwd'];  
$confirmPwd = $_POST['confirmPwd'];




$ris= modificaUtente($cid, $_SESSION["utente"],$_POST["email"], $_POST["pwd"],$_POST["confirmPwd"],$_POST["Nome"],$_POST["Cognome"],$_POST["dataN"],$_POST["cittaN"],$_POST["provinciaN"],$_POST["statoN"],$_POST["cittaR"],$_POST["provinciaR"],$_POST["statoR"],$_POST["orientamento"]);
$errore = $ris["tipoErrore"];
$newEmail = $_POST["email"];
// $dati = $ris["contenuto"];
$pwd = $_POST["pwd"];
if (($ris["status"]=='ok')) {
		$_SESSION["utente"] = $newEmail;

        $location="../frontend/modifica-profilo";
		header("location:$location.php?status=ok&!errore=".serialize($errore)."&dati=".serialize($dati)); 
}
else{	        
        $_SESSION["status"] = "ko";
		$location="../frontend/modifica-profilo";
        header("location:$location.php?status=ko&errore=".serialize($errore)."&dati=".serialize($dati)); 
}
?>