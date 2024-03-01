<?php
session_start();
require_once("../commons/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
	$timestamp = isset($_POST["timestamp"]) ? $_POST["timestamp"] : "";}

$sql = "DELETE FROM post WHERE post.email = ? AND post.timestampPubblicazione = ?;";
$stmt = $cid->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $email, $timestamp );
    $stmt->execute();


    $stmt->close();

}   
$cid->close();
?>   

 