<?php
include '../commons/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeAmico = isset($_POST["nomeAmico"]) ? $_POST["nomeAmico"] : "";
	$cognomeAmico = isset($_POST["cognomeAmico"]) ? $_POST["cognomeAmico"] : "";
	$emailUtenteLoggato = isset($_POST["emailUtenteLoggato"]) ? $_POST["emailUtenteLoggato"] : "";
	
	 $queryEliminaAmico = "DELETE FROM richiestediamicizia
                         WHERE statoRichiesta = 'accettato'
                           AND (
                               (mittente = ? AND destinatario IN (SELECT email FROM utente WHERE nome = ? AND cognome = ?))
                               OR
                               (destinatario = ? AND mittente IN (SELECT email FROM utente WHERE nome = ? AND cognome = ?))
                           )";

    $stmtEliminaAmico = $cid->prepare($queryEliminaAmico);
	$stmtEliminaAmico->bind_param("ssssss", $emailUtenteLoggato, $nomeAmico, $cognomeAmico, $emailUtenteLoggato, $nomeAmico, $cognomeAmico);
    $stmtEliminaAmico->execute();

    if ($stmtEliminaAmico->affected_rows > 0) {
        echo "Amico eliminato con successo";
    } else {
        echo "Errore durante l'eliminazione dell'amico";
    }
}	
	
?>