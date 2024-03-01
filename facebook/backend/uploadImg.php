<?php

//il caricamento immagini non funziona, questo file è stato un tentativo. L'immagine viene visualizzata ma non siamo riusciti a fare 
//in modo che venisse copiata nei file del progetto al momento del caricamento.

require("../commons/connection.php");

if(isset($_FILES['immagine'])) {
    $file_name = $_FILES['immagine']['name'];
    $tmp_name = $_FILES['immagine']['tmp_name'];

    // Ottieni l'estensione del file
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Verifica che l'estensione sia consentita (puoi aggiungere altre estensioni se necessario)
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($file_extension, $allowed_extensions)) {
        die("Errore: Estensione del file non consentita.");
    }

    // Imposta il percorso di destinazione
    $upload_path = '../uploads/';

    // Sposta il file nella cartella di destinazione
    $status = "";
   if(move_uploaded_file($tmp_name,$upload_path)){
    $status = "ok";
    $location="../frontend/home-page";
    header("location:$location.php?status=ok&!status=".serialize($status));     
   }else{
    $status = "ko";
    header("location:$location.php?status=ok&!status=".serialize($status));
   }
?>
