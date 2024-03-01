<?php

include '../commons/connection.php';
include '../commons/funzioni.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = isset($_POST["email"]) ? $_POST["email"] : "";
	sbloccaUtente($cid, $email);
    
}	
	
?>