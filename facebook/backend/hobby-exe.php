<?php 
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();

$ris = inserisciHobbyUtente($cid,$_SESSION['utente'],$_POST["nomeHobby"]);
$msg = $ris['msg'];
if (($ris["status"]=='ok')) {
    $location="../frontend/modifica-profilo";
    header("location:$location.php?status=ok&!msg=".serialize($msg)); 
}
else{	        
    $_SESSION["status"] = "ko";
    $location="../frontend/modifica-profilo ";
    header("location:$location.php?status=ko&msg=".serialize($msg)); 
}

?>