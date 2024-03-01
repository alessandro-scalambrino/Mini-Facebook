<?php

include '../commons/connection.php';

session_start();
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;

if ($emailUtenteLoggato) {

    $query = "SELECT DISTINCT utente.nome, utente.cognome, utente.email
              FROM utente
              WHERE utente.bloccato = 'si'";

    $stmt = $cid->prepare($query);

    if ($stmt) {

        $stmt->execute();

        $result = $stmt->get_result();

        $bloccati = [];

        while ($row = $result->fetch_assoc()) {
            $bloccati[] = array(
                'nome' => $row['nome'],
                'cognome' => $row['cognome'],
                'email' => $row['email']
            );
        }


        $stmt->close();

        header('Content-Type: application/json');
        echo json_encode($bloccati);
    } else {

        die("Errore nella preparazione della query: " . $cid->error);
    }

    $cid->close();
} else {

    die("Utente non loggato");
}
?>
