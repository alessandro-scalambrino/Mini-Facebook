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
                            <label>UTENTI BLOCCATI:</label>
                            <ul class="list-group" id="lista-bloccati">
                                <li class="list-group-item title"></li>
									<!-- /lista dinamica amici -->
                            </ul>
					    <button id="btnAggiornaAmici" class="btn btn-primary">Aggiorna</button>

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
        url: '../backend/ottieni-utenti-bloccati.php',
        success: function (data) {
			console.log(data)
            // Manipola i dati ottenuti dalla chiamata AJAX e li visualizza
            if (data.length > 0) {
                var amiciHtml = '';
                for (var i = 0; i < data.length; i++) {
                    amiciHtml += '<li class="list-group-item text-left">';
                    amiciHtml += '<label>' + data[i].nome + ' ' + data[i].cognome + '<br></label>';
					amiciHtml += '<button class="btn btn-primary btn-sblocca-amico pull-right" data-email="' + data[i].nome + '|' + data[i].cognome + '|' + data[i].email + '">Sblocca</button>';
					amiciHtml += '<label class="pull-right">';
					amiciHtml += '</label>';
					amiciHtml += '<div class="break"></div>';
					amiciHtml += '</li>';

                }

                // Aggiungi gli elementi alla lista delle richieste di amicizia
                $('#lista-bloccati').html(amiciHtml);

                // Aggiungi clickaction per il pulsante "Sblocca"
                $('.btn-sblocca-amico').click(function () {
				var emailAmico = $(this).data('email');
				//funzione per eliminare l'amico dalla lista degli amici
				sbloccaUtente(emailAmico);
			});
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore durante la chiamata AJAX:', status, error);
        }
    });
}

function sbloccaUtente(emailAmico) {
    // Separa i valori email (è inutile ma l'ho copiato da ottieni-amici quindi gestisce lo stesso obj
    var emailParts = emailAmico.split('|');
    var email = emailParts[2];

    $.ajax({
        type: 'POST',  // Metodo HTTP
        url: '../backend/sblocca-utente.php',  // URL del tuo backend
        data: {
            
			email: email
        },  
        success: function (response) {
            ottieniAmici();
        },
        error: function (xhr, status, error) {
            console.error('Errore durante la chiamata AJAX:', status, error);
        }
    });
}
$(document).ready(function () {
    // Chiamata iniziale per ottenere gli amici quando la pagina è pronta
    ottieniAmici();
});
</script>
</body>

</html>