<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();

$ris = eliminaUtente($cid, $_POST["utenteElimina"]);
$msg = $ris["msg"];

if ($ris["status"] == 'ok') {

    $location = "../frontend/vista-admin";
    header("location:$location.php?status=ok&!msg=" . serialize($msg));
} else {
    $_SESSION["status"] = "ko";
    $location = "../frontend/vista-admin";
    header("location:$location.php?status=ko&msg=" . serialize($msg));
}
?>
