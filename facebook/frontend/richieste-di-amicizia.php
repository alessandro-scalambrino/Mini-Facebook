<!-- quessta funzione ottiene l'email dell'utente loggato -->
<?php
session_start();
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../commons/header.php'; ?>
<?php include '../assets/js/richiesta-amicizia.js'; ?>


<body>

        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">
                <div class="column col-sm-12" id="main">
                    <!-- navbar -->
                    <?php include '../commons/navbar.php'; ?>
             

                    <div class="padding">
                        <div class="jumbotron list-content">
                            <ul class="list-group" id="lista-richieste-amicizia">
                                <li class="list-group-item title">
                                    Richieste d'amicizia in sospeso
                                </li>
                                <!-- Lista dinamica delle richieste di amicizia -->
                            </ul>
					    <div id="messaggioRichiestaAccettata" style="display: none;" class="alert alert-success">
												Richiesta accettata con successo!
						</div>
						<div id="messaggioRichiestaRifiutata" style="display: none;" class="alert alert-success">
												Richiesta rifutata con successo!
						</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <!--post modal-->
    <?php include '../commons/postmodal.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Chiamata alla funzione ottieniRichiesteDiAmicizia al caricamento della pagina
            ottieniRichiesteDiAmicizia();
        });
    </script>
</head>
</body>

</html>