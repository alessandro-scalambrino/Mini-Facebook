<?php
include '../commons/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $hobby = isset($_POST["nomeHobby"]) ? $_POST["nomeHobby"] : NULL;
    $citta = isset($_POST["cittaR"]) ? $_POST["cittaR"] : "";
    $utente_loggato = isset($_POST["utente_loggato"]) ? $_POST["utente_loggato"] : ""; 
    $orientamento = isset($_POST["orientamento"]) ? $_POST["orientamento"] : "";
    // Array risultante
    $results = [];

    $SearchQuery = "SELECT nome, cognome FROM utente WHERE 1=1";

    if ($orientamento != NULL) {
        $SearchQuery .= " AND (orientamentoSessuale = ?)";
    }
    if ($citta != NULL) {
        $SearchQuery .= " AND (cittaR = ?)";
    }
    if ($hobby != NULL) {
        $SearchQuery .= " AND email IN (SELECT utente FROM pratica WHERE hobby = ?)";
    }

    $stmtSearch = $cid->prepare($SearchQuery);
    
    // Bind dei parametri
    if (($hobby != NULL) && ($orientamento != NULL) && ($citta != NULL)) { //tutti i parametri settati 
        $stmtSearch->bind_param("sss", $orientamento, $citta, $hobby);
    } elseif(($orientamento != NULL) && ($citta != NULL)) { //ricerca per città e orientamento 
        $stmtSearch->bind_param("ss", $orientamento, $citta);
    }elseif(($hobby != NULL) && ($citta != NULL)){ //ricerca per città e hobby 
        $stmtSearch->bind_param("ss", $citta,$hobby);
    }elseif(($hobby != NULL) && ($orientamento != NULL)){ //ricerca per hobby e città 
        $stmtSearch->bind_param("ss", $orientamento,$hobby);
    }elseif(($citta != NULL)) { //ricerca per città 
        $stmtSearch->bind_param("s", $citta);
    }elseif(($hobby != NULL) ){ //ricerca per hobby 
        $stmtSearch->bind_param("s",$hobby);
    }elseif(($orientamento != NULL)){ //ricerca per orientamento
        $stmtSearch->bind_param("s",$orientamento);
    }
    
    $stmtSearch->execute();
    $Result = $stmtSearch->get_result();

    while ($row = $Result->fetch_assoc()) {
        // Aggiungi nome e cognome al risultato
        $results[] = ['nome' => $row['nome'], 'cognome' => $row['cognome']];
    }

    // Encode the results as JSON and echo
    echo json_encode(['data' => $results]);
}
?>
