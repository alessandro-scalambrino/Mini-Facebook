<?php

include '../commons/connection.php';


session_start();
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;


$sql = "SELECT DISTINCT p.*, u.nome, u.cognome
        FROM post p
        JOIN utente u ON u.email = p.email
        LEFT JOIN richiestediamicizia a ON p.email = a.mittente OR p.email = a.destinatario
        WHERE (a.mittente = ? OR a.destinatario = ? AND a.statoRichiesta = 'accettato') OR a.mittente IS NULL
        ORDER BY p.timestampPubblicazione DESC;";
$stmt = $cid->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $emailUtenteLoggato, $emailUtenteLoggato);
    $stmt->execute();

    $result = $stmt->get_result();
	 
    $post = [];
	
    while ($row = $result->fetch_assoc()) {
        $post[] = $row;
    }

    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode($post);
} else {
    die("Errore nella preparazione della query: " . $cid->error);
}

$cid->close();
?>