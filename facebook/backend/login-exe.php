<?php
session_start();
include_once "../commons/connection.php";
include_once "../commons/funzioni.php";

$login = $_POST["email"];
$pwd = $_POST["pwd"];
$ris = isUser($cid, $login, $pwd);
$msg = $ris["msg"];
if ($ris["status"] == 'ko') {
    header('location: ../frontend/index.php?status=ko&msg=' . json_encode($msg));
} else {
    $_SESSION["utente"] = $login;
    $_SESSION["logged"] = true;


    header("location: ../frontend/home-page.php?status=ok&msg=" . urlencode($ris["msg"]));
}
?>