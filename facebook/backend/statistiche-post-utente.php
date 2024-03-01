<?php
include_once("../commons/connection.php");
include_once("../commons/funzioni.php");
session_start();

$contenuto = calcolaStatistichePost($cid, $_POST["utentePost"]);
$min = $contenuto["min"];
$max = $contenuto["max"];
$mean = $contenuto["mean"];

$location = "../frontend/vista-admin";
header("location:$location.php?min=" . json_encode($min) . "&max=" . json_encode($max) . "&mean=" . json_encode($mean));


?>