<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();

$emailUtente = isset($_POST["emailUtente"]) ? $_POST["emailUtente"] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["utenteBlocca"])) {
	$msg = bloccaUtente($cid, $_POST["utenteBlocca"]);
	$location = "../frontend/vista-admin";
	header("location:$location.php?blockedMsg=" . json_encode($msg));
} else {
	bloccaUtente($cid, $emailUtente);
	$location = "../frontend/risultati-ricerca";
	header("location:$location.php?blockedMsg=" . json_encode($msg));
}


?>