<?php
include '../commons/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchTerm = $_GET["srch-term"];
    $logged_user = $_SESSION["utente"];

    $emailSearchQuery = "SELECT DISTINCT email, nome, cognome FROM utente WHERE email != ? AND email LIKE ?";
    $nameSearchQuery = "SELECT DISTINCT email, nome, cognome FROM utente WHERE CONCAT(nome, ' ',cognome) LIKE ? AND email != ?";

    $searchTermWithWildcard = "%" . $searchTerm . "%";

    $results = [];

    // Esecuzione della query sulla ricerca per email solo se la stringa di ricerca non è vuota
    if (!empty($searchTerm)) {
        $stmtEmailSearch = $cid->prepare($emailSearchQuery);
        $stmtEmailSearch->bind_param("ss", $logged_user, $searchTermWithWildcard);
        $stmtEmailSearch->execute();
        $emailResult = $stmtEmailSearch->get_result();

        while ($row = $emailResult->fetch_assoc()) {
            $results[$row['email']] = $row;
        }
    }

    // Esecuzione della query sulla ricerca per nome e cognome
    $stmtNameSearch = $cid->prepare($nameSearchQuery);
    $stmtNameSearch->bind_param("ss", $searchTermWithWildcard, $logged_user);
    $stmtNameSearch->execute();
    $nameResult = $stmtNameSearch->get_result();

    while ($row = $nameResult->fetch_assoc()) {
        $results[$row['email']] = $row;
    }

    // Encode dei risultati come JSON e output
    echo json_encode(array_values($results));
}
?>
