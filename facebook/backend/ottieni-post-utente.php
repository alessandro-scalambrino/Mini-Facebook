<?php

include '../commons/connection.php';


session_start();
$emailBacheca = $_GET['emailBacheca'];


$sql = "SELECT u.nome, u.cognome, u.email, p.*
		FROM utente u
		JOIN post p ON u.email = p.email
		WHERE u.email = ?
		ORDER BY p.timestampPubblicazione DESC;";
$stmt = $cid->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $emailBacheca);
    $stmt->execute();

    $result = $stmt->get_result();
	 
    $post = [];
	
    while ($row = $result->fetch_assoc()) {
        $post[] = $row;
    }

    $stmt->close();

    // Restituisci i dati come JSON
    header('Content-Type: application/json');
    echo json_encode($post);
} else {
    // Errore nella preparazione della query
    die("Errore nella preparazione della query: " . $cid->error);
}

// Chiudi la connessione al database
$cid->close();
?>