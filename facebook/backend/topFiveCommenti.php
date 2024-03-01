<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();

$contenuto = calcolatop5utenti($cid);

$location = "../frontend/vista-admin";
header("location:$location.php?top5=" . json_encode($contenuto));

?>