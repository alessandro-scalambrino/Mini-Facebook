<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();




//METTERE UN BELL'IF IN BASE AL VALORE DI AZIONE se tolgo l'if funziona

if ($_POST['azione'] == "incrementa_post") {
    $risposta = aumentaGradimentoPost($cid, $_POST['timestamp'], $_POST['email']);
} else if ($_POST['azione'] == "decrementa_post") {
    $risposta = diminuisciGradimentoPost($cid, $_POST['timestamp'], $_POST['email']);
} else if ($_POST['azione'] == "incrementa_commento") {
    $risposta = aumentaGradimentoCommento($cid, $_POST['timestamp'], $_POST['email'], $_POST['timestampC']);
} else if ($_POST['azione'] == "decrementa_commento") {
    $risposta = diminuisciGradimentoCommento($cid, $_POST['timestamp'], $_POST['email'], $_POST['timestampC']);
}


	
    
    echo json_encode($risposta);
	
?>


