<?php

include '../commons/connection.php';
$current_time = $_GET['timestampPubblicazione'];
$current_email = $_GET['email'];


$sql = "SELECT
			commento.timestampCommento,
            commento.timestampPublicazione,
            commento.email,
            commento.testo,
            commento.autore,
			commento.indicediGradimento,
            utente.nome,
            utente.cognome
        FROM
            commento
        JOIN
            post ON commento.timestampPublicazione = post.timestampPubblicazione AND commento.email = post.email
        JOIN
            utente ON commento.autore = utente.email
		WHERE commento.timestampPublicazione = '$current_time'  AND commento.email = '$current_email'";
		
$stmt = $cid->prepare($sql);
error_log("SQL Query: $sql", 3, "./sql_query_trovacommento.log");
if ($stmt) {
    $stmt->execute();

    $result = $stmt->get_result();
	 
    $commenti = [];
	
    while ($row = $result->fetch_assoc()) {
        $commenti[] = $row;
    }

    $stmt->close();

    // Restituisci i dati come JSON
    header('Content-Type: application/json');
    echo json_encode($commenti);
} else {
    // Errore nella preparazione della query
    die("Errore nella preparazione della query: " . $cid->error);
}

// Chiudi la connessione al database
$cid->close();
?>