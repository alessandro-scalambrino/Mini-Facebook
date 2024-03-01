<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
        
        var mittente= "<?php echo $emailUtenteLoggato; ?>";

		function inviaRichiesta(destinatario) {
			console.log("Mittente:", mittente);
			console.log("Destinatario:", destinatario);

			$.ajax({
				type: "POST",
				url: "../backend/richiesta-amicizia.php",
				data: { mittente: mittente, destinatario: destinatario },
				success: function (response) {
					console.log(response);
					// Mostra il messaggio di successo
					$("#messaggioRichiestaInviata").fadeIn();

					// Nasconde il messaggio dopo un certo periodo di tempo
					setTimeout(function () {
						$("#messaggioRichiestaInviata").fadeOut();
					}, 3000); // 3000 millisecondi = 3 secondi
				},
				error: function (error) {
					console.error(error);
					// Gestione degli errori
				}
			});
		}
		
		function accettaRichiesta(destinatario) {
			console.log("Mittente:", mittente);
			console.log("Destinatario:", destinatario);

			$.ajax({
				type: "POST",
				url: "../backend/accetta-richiesta.php",
				data: { mittente: mittente, destinatario: destinatario },
				success: function (response) {
					console.log(response);
					// Mostra il messaggio di successo
					$("#messaggioRichiestaAccettata").fadeIn();

					// Nasconde il messaggio dopo un certo periodo di tempo
					setTimeout(function () {
						$("#messaggioRichiestaAccettata").fadeOut();
					}, 3000); // 3000 millisecondi = 3 secondi
				},
				error: function (error) {
					console.error(error);
					// Gestione degli errori
				}
			});
		}
		
		function rifiutaRichiesta(destinatario) {
			console.log("Mittente:", mittente);
			console.log("Destinatario:", destinatario);

			$.ajax({
				type: "POST",
				url: "../backend/rifiuta-richiesta.php",
				data: { mittente: mittente, destinatario: destinatario },
				success: function (response) {
					console.log(response);
					// Mostra il messaggio di successo
					$("#messaggioRichiestaRifiutata").fadeIn();

					// Nasconde il messaggio dopo un certo periodo di tempo
					setTimeout(function () {
						$("#messaggioRichiestaRifiutata").fadeOut();
					}, 3000); // 3000 millisecondi = 3 secondi
				},
				error: function (error) {
					console.error(error);
					// Gestione degli errori
				}
			});
		}
		
		function ottieniRichiesteDiAmicizia() {
		// Chiamata AJAX per ottenere le richieste di amicizia
		$.ajax({
			type: 'GET',
			url: '../backend/ottieni-richiesta.php',
			success: function (data) {
				// Manipola i dati ottenuti dalla chiamata AJAX e visualizzali nella pagina
				if (data.length > 0) {
					var richiesteHtml = '';
					for (var i = 0; i < data.length; i++) {
						richiesteHtml += '<li class="list-group-item text-left">';
                            richiesteHtml += '<label>' + data[i].nome + " " + data[i].cognome + '<br></label>';
                            richiesteHtml += '<label class="pull-right">';
                            richiesteHtml += '<a class="btn btn-primary" onclick="accettaRichiesta(\'' + data[i].mittente + '\')" href="#" title="Accetta">Accetta</a>';
                            richiesteHtml += '<a class="btn btn-primary" onclick="rifiutaRichiesta(\'' + data[i].mittente + '\')"href="#" title="Rifiuta">Rifiuta</a>';
                            richiesteHtml += '</label>';
                            richiesteHtml += '<div class="break"></div>';
                            richiesteHtml += '</li>';
					}

					// Aggiungi gli elementi alla lista delle richieste di amicizia
					$('#lista-richieste-amicizia').html(richiesteHtml);
				}
			},
			error: function (xhr, status, error) {
				console.error('Errore durante la chiamata AJAX:', status, error);
			}
		});
	}
	
	function bloccaUtente(emailUtente) {
    var confermaBlocco = confirm("Sei sicuro di voler bloccare questo utente?");
    if (confermaBlocco) {
        $.ajax({
            type: 'POST',
            url: '../backend/blocca-utente.php',
            data: {
                emailUtente: emailUtente
            },
            success: function (response) {
                console.log('Utente bloccato con successo:', response);
            },
            error: function (xhr, status, error) {
                console.error('Errore durante il blocco dell\'utente:', status, error);
            }
        });
    }
}
    </script>