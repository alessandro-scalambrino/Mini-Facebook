var azioniGradimento = {};

$(document).ready(function () {
	console.log('Email utente bacheca:', emailBacheca);
	console.log('Email utente loggato:', emailUtenteLoggato);
	

    $.ajax({
        type: 'GET',
        url: '../backend/ottieni-post-utente.php',
        dataType: 'json',
		data: { emailUtenteLoggato: emailUtenteLoggato,
				emailBacheca: emailBacheca},
        success: function (data) {
            $('#lista-post').empty();
            var postHtml = '';
            data.forEach(function (post, index) {
                postHtml += '<div class="panel panel-default col-sm-10 col-sm-offset-1">';
                postHtml += '<div class="panel-heading">';
                postHtml += '<p"><strong>' + (post.nome || '') + ' ' + (post.cognome || '') + '</strong></p>';
                postHtml += '</div>';
                postHtml += '<div class="panel-body with-margin-bottom">';
                postHtml += '<p>' + (post.testo || '') + '</p>';
                if (post.tipo == "immagine") {
                    postHtml += '<div class = "text-center">';
                    postHtml += '<img src="' + post.percorsoFile + post.nomeFile + ' " width="300" height="300"> ';
                    postHtml += '</div>';    
                }
                postHtml += '</div>';

                visualizzaCommenti(post.timestampPubblicazione, post.email, index);
				
                postHtml += '<div class="panel-footer">';
                postHtml += '<ul class="list-inline">';
                postHtml += '<li><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#commentModal_' + index + '">Commenta</button></li>';
				postHtml += '<li class="space-between" style="margin-right: 10px"></li>';
                postHtml += '<li><button class="btn btn-primary btn-sm like-btn" onclick="incrementaGradimentoPost(' + index + ', \'' + post.timestampPubblicazione + '\', \'' + post.email + '\')"><span class="glyphicon glyphicon-arrow-up"></span></button></li>';
                postHtml += '<li><span class="like-count" id="like-count-' + index + '">' + (post.indicediGradimento || 0) + '</span></li>';
                postHtml += '<li><button class="btn btn-primary btn-sm dislike-btn" onclick="decrementaGradimentoPost(' + index + ', \'' + post.timestampPubblicazione + '\', \'' + post.email + '\')"><span class="glyphicon glyphicon-arrow-down"></span></button></li>';
				postHtml += '<li class="space-between" style="margin-right: 230px"></li>';
				if (post.email === emailUtenteLoggato && post.email === emailBacheca) {
					postHtml += '<li><button class="btn btn-danger btn-sm" onclick="eliminaPost(' + index + ', \'' + post.timestampPubblicazione + '\', \'' + post.email + '\')">Elimina</button></li>';
				}
                postHtml += '<ul class="list-inline">';
				// questa parte è la localizzazione
				if (post.citta !== null) {
					postHtml += '<li><p>' + post.citta + ',</p></li>';
				}
				if (post.provincia !== null) {
					postHtml += '<li><p>' + post.provincia + ',</p></li>';
				}
				if (post.stato !== null) {
					postHtml += '<li><p>' + post.stato + '</p></li>';
				}
				postHtml += '</ul>';
                postHtml += '</ul>';
                postHtml += '</div>';

                postHtml += '</div>';

                var commentModalHtml = '<div class="modal fade" id="commentModal_' + index + '" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">';
                commentModalHtml += '  <div class="modal-dialog" role="document">';
                commentModalHtml += '    <div class="modal-content">';
                commentModalHtml += '      <div class="modal-header">';
                commentModalHtml += '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                commentModalHtml += '          <span aria-hidden="true">&times;</span>';
                commentModalHtml += '        </button>';
                commentModalHtml += '        <h4 class="modal-title text-center" id="commentModalLabel">Sezione commenti</h4>';
                commentModalHtml += '      </div>';
                commentModalHtml += '      <div class="modal-body" id="commentModalBody_' + index + '">';
                commentModalHtml += '      </div>';
                commentModalHtml += '      <div class="modal-footer">';
                commentModalHtml += '        <div class="form-group row">';
                commentModalHtml += '          <textarea class="form-control" id="commentText' + index + '"></textarea>';
                commentModalHtml += '        </div>';
                commentModalHtml += '        <button type="button" class="btn btn-primary" onclick="inviaCommento(' + index + ', \'' + post.timestampPubblicazione + '\', \'' + post.email + '\')">Invia Commento</button>';
                commentModalHtml += '      </div>';
                commentModalHtml += '    </div>';
                commentModalHtml += '  </div>';
                commentModalHtml += '</div>';

                $('body').append(commentModalHtml);
            });

            $('#lista-post').html(postHtml);
        },
    });
});

function visualizzaCommenti(timestampPubblicazione, email, index) {
    $.ajax({
        type: 'GET',
        url: '../backend/ottieni-commenti.php',
        dataType: 'json',
        data: {
            timestampPubblicazione: timestampPubblicazione,
            email: email
        },
        success: function (commenti) {
            
            var modalCommentiHtml = '<div class="modal-body">';
            commenti.forEach(function (commento, commentIndex) {
                modalCommentiHtml += '<p>';
                modalCommentiHtml += '<strong>' + commento.nome + ' ' + commento.cognome + '</strong>: ' + commento.testo;
                modalCommentiHtml += '<button class="btn btn-sm like-btn" onclick="incrementaGradimentoCommento(' + index + ', \'' + commento.timestampPublicazione + '\', \'' + commento.email + '\', \'' + commento.timestampCommento + '\')"><span class="glyphicon glyphicon-arrow-up"></span></button>';
                modalCommentiHtml += '<span class="like-count" id="comment-like-count-' + index + '-' + commentIndex + '">' + (commento.indicediGradimento || 0) + '</span>';
                modalCommentiHtml += '<button class="btn btn-sm dislike-btn" onclick="decrementaGradimentoCommento(' + index + ', \'' + commento.timestampPublicazione + '\', \'' + commento.email + '\', \'' + commento.timestampCommento + '\')"><span class="glyphicon glyphicon-arrow-down"></span></button>';
                modalCommentiHtml += '</p>';
            });
            modalCommentiHtml += '</div>';

            $('#commentModalBody_' + index).html(modalCommentiHtml);
        },
        error: function (xhr, status, error) {
            console.error('Errore durante il recupero dei commenti:', status, error);
            console.log('Dettagli completi:', xhr.responseText);
        }
    });
}

function inviaCommento(index, timestampPubblicazione, email) {
    var testoCommento = $('#commentText' + index).val();
    var timestamp = timestampPubblicazione;
    var autore = emailUtenteLoggato;

    console.log('Contenuto di testoCommento:', testoCommento);
    console.log('autore:', autore);

    $.ajax({
        type: 'POST',
        url: '../backend/invia-commento.php',
        data: {
            email: email,
            testoCommento: testoCommento,
            timestamp: timestamp,
            autore: autore
        },
        success: function (response) {
            console.log('Commento inviato con successo:', response);

            // Aggiungi il nuovo commento alla visualizzazione senza ricaricare la pagina
            var nuovoCommento = {
                nome: autore,  // Aggiungi altri dettagli del commento se necessario
                cognome: '',   // Aggiungi altri dettagli del commento se necessario
                testo: testoCommento,
                timestampPublicazione: timestamp,
                email: email,
                timestampCommento: response.timestampCommento,  // Assicurati che il backend restituisca il timestamp del commento
                indicediGradimento: 0  // Inizializza il gradimento del nuovo commento
            };

            aggiornaVisualizzazioneCommento(index, nuovoCommento);
            $('#commentModal_' + index).modal('hide');
        },
        error: function (xhr, status, error) {
            console.error('Errore durante l\'invio del commento:', status, error);
        }
    });
}

// Aggiorna la visualizzazione del commento senza ricaricare la pagina
function aggiornaVisualizzazioneCommento(index, commento) {
    // Crea l'HTML del nuovo commento
    var nuovoCommentoHtml = '<p>';
    nuovoCommentoHtml += '<strong>' + commento.nome + ' ' + commento.cognome + '</strong>: ' + commento.testo;
    nuovoCommentoHtml += '<button class="btn btn-sm like-btn" onclick="incrementaGradimentoCommento(' + index + ', \'' + commento.timestampPublicazione + '\', \'' + commento.email + '\', \'' + commento.timestampCommento + '\')"><span class="glyphicon glyphicon-arrow-up"></span></button>';
    nuovoCommentoHtml += '<span class="like-count">' + commento.indicediGradimento + '</span>';
    nuovoCommentoHtml += '<button class="btn btn-sm dislike-btn" onclick="decrementaGradimentoCommento(' + index + ', \'' + commento.timestampPublicazione + '\', \'' + commento.email + '\', \'' + commento.timestampCommento + '\')"><span class="glyphicon glyphicon-arrow-down"></span></button>';
    nuovoCommentoHtml += '</p>';

    // Aggiungi il nuovo commento alla fine della lista dei commenti
    $('#commentModalBody_' + index).append(nuovoCommentoHtml);
}

function performGradimentoAction(index, action) {
    if (!azioniGradimento[index]) {
        azioniGradimento[index] = { incrementi: 0, decrementi: 0 };
    }
	
    if (action === 'increment') {
        azioniGradimento[index].incrementi++;
    } else if (action === 'decrement') {
        azioniGradimento[index].incrementi--;
    }
}

function incrementaGradimentoPost(index, timestampPubblicazione, email) {
        var azione = 'incrementa_post';

        performGradimentoAction(index, 'increment');
        $.ajax({
            type: 'POST',
            url: '../backend/indice-gradimento.php',
            data: {
                email: email,
                timestamp: timestampPubblicazione,
                index: index,
                azione: azione
            },
            success: function (response) {
                var responseObject = JSON.parse(response);
                var nuovoIndice = responseObject.nuovoIndice;

                $('#like-count-' + index).text(nuovoIndice + ' (+' + azioniGradimento[index].incrementi + ')');
            },
            error: function (xhr, status, error) {
                console.error('Errore durante incremento IG del post:', status, error);
            }
        });
    }

    function decrementaGradimentoPost(index, timestampPubblicazione, email) {
        var azione = 'decrementa_post';

        performGradimentoAction(index, 'decrement');
        $.ajax({
            type: 'POST',
            url: '../backend/indice-gradimento.php',
            data: {
                email: email,
                timestamp: timestampPubblicazione,
                index: index,
                azione: azione
            },
            success: function (response) {
                var responseObject = JSON.parse(response);
                var nuovoIndice = responseObject.nuovoIndice;

                $('#like-count-' + index).text(nuovoIndice + ' (' + azioniGradimento[index].incrementi + ')');
            },
            error: function (xhr, status, error) {
                console.error('Errore durante decremento IG del post:', status, error);
            }
        });
    }

    function incrementaGradimentoCommento(index, timestampPublicazione, email, timestampCommento) {
        var azione = 'incrementa_commento';

        performGradimentoAction(index, 'increment');
        $.ajax({
            type: 'POST',
            url: '../backend/indice-gradimento.php',
            data: {
                email: email,
                timestamp: timestampPublicazione,
                timestampC: timestampCommento,
                index: index,
                azione: azione
            },
            success: function (response) {
                var responseObject = JSON.parse(response);
                var nuovoIndice = responseObject.nuovoIndice;

                $('#comment-like-count-' + index).text(nuovoIndice + ' (+' + azioniGradimento[index].incrementi + ')');
                visualizzaCommenti(timestampPublicazione, email, index);
            },
            error: function (xhr, status, error) {
                console.error('Errore durante incremento IG del commento:', status, error);
            }
        });
    }

    function decrementaGradimentoCommento(index, timestampPublicazione, email, timestampCommento) {
        var azione = 'decrementa_commento';

        performGradimentoAction(index, 'decrement');
        $.ajax({
            type: 'POST',
            url: '../backend/indice-gradimento.php',
            data: {
                email: email,
                timestamp: timestampPublicazione,
                timestampC: timestampCommento,
                index: index,
                azione: azione
            },
            success: function (response) {
                var responseObject = JSON.parse(response);
                var nuovoIndice = responseObject.nuovoIndice;

                $('#comment-like-count-' + index).text(nuovoIndice + ' (+' + azioniGradimento[index].incrementi + ')');
                visualizzaCommenti(timestampPublicazione, email, index);
            },
            error: function (xhr, status, error) {
                console.error('Errore durante decremento IG del commento:', status, error);
            }
        });
    }

function eliminaPost(index, timestampPubblicazione, email) {
    // Conferma l'eliminazione del post
    var confermaEliminazione = confirm("Sei sicuro di voler eliminare questo post?");
    if (confermaEliminazione) {
        $.ajax({
            type: 'POST',
            url: '../backend/elimina-post.php',
            data: {
                email: email,
                timestamp: timestampPubblicazione
            },
            success: function (response) {
                console.log('Post eliminato con successo:', response);

                // Rimuovi il post dalla visualizzazione senza ricaricare la pagina
                $('#lista-post .panel').eq(index).remove();

                // Aggiorna la visualizzazione
                $('#lista-post').html('');

                // Richiedi nuovamente i post aggiornati
                caricaPostUtente();
            },
            error: function (xhr, status, error) {
                console.error('Errore durante l\'eliminazione del post:', status, error);
            }
        });
    }
}

// Funzione per caricare i post aggiornati dopo l'eliminazione di un post
function caricaPostUtente() {
    $.ajax({
        type: 'GET',
        url: '../backend/ottieni-post-utente.php',
        dataType: 'json',
        data: {
            emailUtenteLoggato: emailUtenteLoggato,
            emailBacheca: emailBacheca
        },
        success: function (data) {
            // Ricarica i post aggiornati
            aggiornaVisualizzazionePost(data);
        },
    });
}

// Funzione per aggiornare la visualizzazione dei post
function aggiornaVisualizzazionePost(data) {
    var postHtml = '';
    data.forEach(function (post, index) {
        postHtml += '<div class="panel panel-default col-sm-10 col-sm-offset-1">';
                postHtml += '<div class="panel-heading">';
                postHtml += '<p"><strong>' + (post.nome || '') + ' ' + (post.cognome || '') + '</strong></p>';
                postHtml += '</div>';
                postHtml += '<div class="panel-body with-margin-bottom">';
                postHtml += '<p>' + (post.testo || '') + '</p>';
                if (post.tipo == "immagine") {
                    postHtml += '<div class = "text-center">';
                    postHtml += '<img src="' + post.percorsoFile + post.nomeFile + ' " width="300" height="300"> ';
                    postHtml += '</div>';    
                }
                postHtml += '</div>';

                visualizzaCommenti(post.timestampPubblicazione, post.email, index);
				
                postHtml += '<div class="panel-footer">';
                postHtml += '<ul class="list-inline">';
                postHtml += '<li><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#commentModal_' + index + '">Commenta</button></li>';
				postHtml += '<li class="space-between" style="margin-right: 10px"></li>';
                postHtml += '<li><button class="btn btn-primary btn-sm like-btn" onclick="incrementaGradimentoPost(' + index + ', \'' + post.timestampPubblicazione + '\', \'' + post.email + '\')"><span class="glyphicon glyphicon-arrow-up"></span></button></li>';
                postHtml += '<li><span class="like-count" id="like-count-' + index + '">' + (post.indicediGradimento || 0) + '</span></li>';
                postHtml += '<li><button class="btn btn-primary btn-sm dislike-btn" onclick="decrementaGradimentoPost(' + index + ', \'' + post.timestampPubblicazione + '\', \'' + post.email + '\')"><span class="glyphicon glyphicon-arrow-down"></span></button></li>';
				postHtml += '<li class="space-between" style="margin-right: 230px"></li>';
				if (post.email === emailUtenteLoggato && post.email === emailBacheca) {
					postHtml += '<li><button class="btn btn-danger btn-sm" onclick="eliminaPost(' + index + ', \'' + post.timestampPubblicazione + '\', \'' + post.email + '\')">Elimina</button></li>';
				}
                postHtml += '<ul class="list-inline">';
				// questa parte è la localizzazione
				if (post.citta !== null) {
					postHtml += '<li><p>' + post.citta + ',</p></li>';
				}
				if (post.provincia !== null) {
					postHtml += '<li><p>' + post.provincia + ',</p></li>';
				}
				if (post.stato !== null) {
					postHtml += '<li><p>' + post.stato + '</p></li>';
				}
				postHtml += '</ul>';
                postHtml += '</ul>';
                postHtml += '</div>';

                postHtml += '</div>';

                var commentModalHtml = '<div class="modal fade" id="commentModal_' + index + '" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">';
                commentModalHtml += '  <div class="modal-dialog" role="document">';
                commentModalHtml += '    <div class="modal-content">';
                commentModalHtml += '      <div class="modal-header">';
                commentModalHtml += '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                commentModalHtml += '          <span aria-hidden="true">&times;</span>';
                commentModalHtml += '        </button>';
                commentModalHtml += '        <h4 class="modal-title text-center" id="commentModalLabel">Sezione commenti</h4>';
                commentModalHtml += '      </div>';
                commentModalHtml += '      <div class="modal-body" id="commentModalBody_' + index + '">';
                commentModalHtml += '      </div>';
                commentModalHtml += '      <div class="modal-footer">';
                commentModalHtml += '        <div class="form-group row">';
                commentModalHtml += '          <textarea class="form-control" id="commentText' + index + '"></textarea>';
                commentModalHtml += '        </div>';
                commentModalHtml += '        <button type="button" class="btn btn-primary" onclick="inviaCommento(' + index + ', \'' + post.timestampPubblicazione + '\', \'' + post.email + '\')">Invia Commento</button>';
                commentModalHtml += '      </div>';
                commentModalHtml += '    </div>';
                commentModalHtml += '  </div>';
                commentModalHtml += '</div>';

                $('body').append(commentModalHtml);
    });

    // Aggiorna la visualizzazione dei post
    $('#lista-post').html(postHtml);
}