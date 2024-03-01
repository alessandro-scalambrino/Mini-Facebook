
		function inviaRichiesta(destinatario, mittente) {
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

$(document).ready(function () {
    $('#btnInviaRicerca').on('click', function (e) {
        e.preventDefault(); // Evita l'invio normale del form

        var formData = $('#formRicercaAvanzata').serialize();
        console.log('Dati del form:', formData);
		
		
        $.ajax({
            type: 'POST',
            url: '../backend/ricerca-avanzata-exe.php',
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                if (data && Array.isArray(data.data) && data.data.length > 0) {
                    var risultatiRicercaHtml = '';
                    for (var i = 0; i < data.data.length; i++) {
                        risultatiRicercaHtml += '<li class="list-group-item text-left">';
                        risultatiRicercaHtml += '<label>' + data.data[i].nome + " " + data.data[i].cognome + '<br></label>';
                        risultatiRicercaHtml += '<label class="pull-right">';
                        risultatiRicercaHtml += '<a onclick="inviaRichiesta(\'' + data.data[i].utente  + '\', \'' + data.data[i].utente_loggato + '\')" class="btn btn-primary" href="#" title="Aggiungi">Aggiungi</a>';
                        risultatiRicercaHtml += '</label>';
                        risultatiRicercaHtml += '<div class="break"></div>';
                        risultatiRicercaHtml += '</li>';
                    }

                    $('#lista-risultati-ricerca').html(risultatiRicercaHtml);
                } else {
                    // Nessun risultato trovato, mostra un messaggio appropriato
                    $('#lista-risultati-ricerca').html('<p>Nessun risultato trovato.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Errore durante la chiamata AJAX:', status, error);
            }
        });
    });
});
