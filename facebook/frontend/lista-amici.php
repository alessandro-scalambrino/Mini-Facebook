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
                            <label> I TUOI AMICI:</label>
                            <ul class="list-group" id="lista-amici">
                                <li class="list-group-item title"></li>
									<!-- /lista dinamica amici -->
                            </ul>
							<button id="btnAggiornaAmici" class="btn btn-primary" onclick="ottieniAmici()">Aggiorna Amici</button>

                        </div>
                    </div>
                </div>
            </div>           
        </div>
    

    <!--post modal-->
    <?php include '../commons/postmodal.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    // Dichiarazione della funzione ottieniAmici all'esterno di $(document).ready
    function ottieniAmici() {
    var emailUtenteLoggato = "<?php echo $emailUtenteLoggato; ?>";

    $.ajax({
        type: 'GET',
        url: '../backend/ottieni-amici.php',
        success: function (data) {
			console.log(data)
            // Manipola i dati ottenuti dalla chiamata AJAX e li visualizza nella pagina
            if (data.length > 0) {
                var amiciHtml = '';
                for (var i = 0; i < data.length; i++) {
                    amiciHtml += '<li class="list-group-item text-left">';
                    amiciHtml += '<label>' + data[i].nome + ' ' + data[i].cognome + '<br></label>';
					amiciHtml += '<button class="btn btn-danger btn-elimina-amico pull-right" data-email="' + data[i].nome + '|' + data[i].cognome + '|' + emailUtenteLoggato + '">Elimina</button>';
					amiciHtml += '<label class="pull-right">';
					amiciHtml += '</label>';
					amiciHtml += '<div class="break"></div>';
					amiciHtml += '</li>';

                }

                // Aggiunge gli elementi alla lista delle richieste di amicizia
                $('#lista-amici').html(amiciHtml);

                // Aggiunge clickaction per il pulsante "Elimina dagli Amici"
                $('.btn-elimina-amico').click(function () {
				var emailAmico = $(this).data('email');
				// Chiamata AJAX o funzione per eliminare l'amico dalla lista degli amici
				eliminaAmico(emailAmico);
			});
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore durante la chiamata AJAX:', status, error);
        }
    });
}

function eliminaAmico(emailAmico) {
    // Separare i valori dell'email 
    var emailParts = emailAmico.split('|');
    var nomeAmico = emailParts[0];
    var cognomeAmico = emailParts[1];
    var emailUtenteLoggato = emailParts[2];

    $.ajax({
        type: 'POST',  // Metodo HTTP
        url: '../backend/elimina-amico.php',  // URL del tuo backend
        data: {
            nomeAmico: nomeAmico,
            cognomeAmico: cognomeAmico,
            emailUtenteLoggato: emailUtenteLoggato
        },  // Dati da inviare al backend
        success: function (response) {
            // Operazioni da eseguire in caso di successo
            ottieniAmici();
        },
        error: function (xhr, status, error) {
            console.error('Errore durante la chiamata AJAX:', status, error);
        }
    });
}
$(document).ready(function () {
    // Chiamata iniziale per ottenere gli amici
    ottieniAmici();
});
</script>
</body>

</html>