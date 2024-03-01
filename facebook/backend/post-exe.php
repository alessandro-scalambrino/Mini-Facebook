<?php 
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();
#valori che possono essere null
$citta = isset($_POST['citta']) ? $_POST['citta'] : null;
$prov = isset($_POST['prov']) ? $_POST['prov'] : null;
$stato = isset($_POST['stato']) ? $_POST['stato'] : null;

$ris = inserisciPost($cid,$_SESSION['utente'],$_POST['testo'],$_POST['citta'],$_POST['prov'],$_POST['stato'], $_POST['nomeFile'], $_POST['percorsoFile']);
    $media_gradimento = calcolaRispettabilita($cid, $_SESSION["utente"]);

    if ($media_gradimento < 0) {
        // Decrementa l'indice di rispettabilità
        $rispettabilita = decrementaIndice($cid, $_SESSION["utente"]);
		
        // Verifica se l'indice di rispettabilità è inferiore a -1 e blocca
        if ($rispettabilita < -1) {
            bloccaUtente($cid, $_SESSION["utente"]);
        }

    }
$msg = $ris['msg'];
if (($ris["status"]=='ok')) {
    $location="../frontend/home-page";
    header("location:$location.php?status=ok&!errore=".serialize($msg)); 
}
else{	        
    $_SESSION["status"] = "ko";
    $location="../frontend/home-page";
    header("location:$location.php?status=ko&errore=".serialize($msg)); 
}
