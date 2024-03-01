<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();

$msg = "";
$status = "";
if (isBlocked($cid, $_SESSION["utente"]) == "si") {
    $msg = "Non puoi inserire un commento perché il tuo account è bloccato.";
    $status = "ko";
    $msg = "il tuo account è stato bloccato, non puoi inserire commenti.";

}else{
    $ris = inserisciCommento($cid, $_POST['timestamp'], $_POST['email'],  $_POST['testoCommento'],$_POST['autore'] );
	
	//funzioni per calcolareRisp
    $media_gradimento = calcolaRispettabilita($cid, $_SESSION["utente"]);

    if ($media_gradimento <= 1) {
        // Decrementa l'indice di rispettabilità
        $rispettabilita = decrementaIndice($cid, $_SESSION["utente"]);
        // Verifica se l'indice di rispettabilità è inferiore a -1  e blocca
        if ($rispettabilita < -1) {
            bloccaUtente($cid, $_SESSION["utente"]);
        }

    }
    $status = $ris["status"];
    $msg = $ris["msg"];
}

$location = "../frontend/home-page";
header("location:$location.php?status=" . json_encode($status) . "&msg=" . json_encode($msg));

?>