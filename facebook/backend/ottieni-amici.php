<?php
include '../commons/connection.php';


session_start();
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;

$query = "SELECT DISTINCT utente.nome, utente.cognome
            FROM utente
            JOIN richiestediamicizia r ON (utente.email = r.mittente OR utente.email = r.destinatario)
            WHERE (r.mittente = ? OR r.destinatario = ?)
            AND r.statoRichiesta = 'accettato'
            AND utente.email <> ?;";


$stmt = $cid->prepare($query);

if ($stmt) {
    $stmt->bind_param("sss", $emailUtenteLoggato, $emailUtenteLoggato,$emailUtenteLoggato);
    $stmt->execute();

    $result = $stmt->get_result();
	
	
	
    $amici = [];

    while ($row = $result->fetch_assoc()) {
        $amici[] = array(
            'nome' => $row['nome'],
            'cognome' => $row['cognome']
        );
    }
    

    $stmt->close();

    // Restituisci i dati come JSON
    header('Content-Type: application/json');
    echo json_encode($amici);
} else {
    // Errore nella preparazione della query
    die("Errore nella preparazione della query: " . $cid->error);
}

// Chiudi la connessione al database
$cid->close();
?>