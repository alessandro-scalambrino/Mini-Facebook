<?php

include '../commons/connection.php';


session_start();
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;


$query = "SELECT DISTINCT r.*, u.nome, u.cognome
FROM richiestediamicizia r
JOIN utente u ON r.mittente = u.email
WHERE r.destinatario = ? AND r.statoRichiesta = 'in attesa di accettazione'";
$stmt = $cid->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $emailUtenteLoggato);
    $stmt->execute();

    $result = $stmt->get_result();

    $richieste = [];

    while ($row = $result->fetch_assoc()) {
        $richieste[] = $row;
    }

    $stmt->close();


    header('Content-Type: application/json');
    echo json_encode($richieste);
} else {

    die("Errore nella preparazione della query: " . $cid->error);
}

$cid->close();
?>