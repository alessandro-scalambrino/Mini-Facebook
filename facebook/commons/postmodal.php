<?php require_once("../commons/funzioni.php")?>

<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                Update Status
            </div>
            <form class="form center-block" method="POST" action="../backend/post-exe.php">
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?" name="testo"></textarea>
                        <input type="hidden" id="hiddenCitta" name="citta">
                        <input type="hidden" id="hiddenProv" name="prov">
                        <input type="hidden" id="hiddenStato" name="stato">
						<input type="hidden" id="hiddenNomeFile" name="nomeFile">
						<input type="hidden" id="hiddenPercorsoFile" name="percorsoFile">
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button class="btn btn-primary btn-sm" type="button" id="inviaPost">POST</button>
                        <ul class="pull-left list-inline">
                            <li><a href="#immagineModal" data-toggle="modal"><i class="glyphicon glyphicon-upload"></i></a></li>
                            <li><a href="#cittaModal" data-toggle="modal"><i class='glyphicon glyphicon-map-marker'></i></a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
											<?php // Recupera i dati per i dropdown localizzazione
                                                $queryCitta = "SELECT DISTINCT nomeCitta FROM citta";
                                                $resultCitta = $cid->query($queryCitta);

                                                $queryProvincia = "SELECT DISTINCT provincia FROM citta ORDER BY provincia";
                                                $resultProvincia = $cid->query($queryProvincia);

                                                $queryStato = "SELECT DISTINCT stato FROM citta";
                                                $resultStato = $cid->query($queryStato);

												$queryHobby = "SELECT DISTINCT nomeHobby FROM  hobby";
												$resultHobby = $cid->query($queryHobby);
                                                ?>
<!-- modal per l'inserimento della localizzazione -->
<div id="cittaModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form center-block" method="POST">
                <div class="modal-body">
                    <div class="form-group text-center" style="padding: 10px;">
                        <label for="nomecitta">Seleziona una città</label>
                        	<div class="row">
														<div class="col-md-4">
															<select class="form-control" id="citta" name="citta">
                                                                <?php //codice per popolare il dropdown 
                                                                if(ottieniCittaR($cid,$_SESSION["utente"])){ 
																	$value = ottieniCittaR($cid,$_SESSION["utente"]);
                                                                    echo "<option value='". $value ."'>". $value  ."</option>";
                                                                }else {
                                                                    echo "<option value='". "città" ."'>"."città"."</option>";
                                                                }
                                                                while ($row = $resultCitta->fetch_assoc()) {
                                                                    echo "<option value='" . $row['nomeCitta'] . "'>" . $row['nomeCitta'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
														</div>
														<div class="col-md-4">
															<select class="form-control" id="prov" name="prov">
                                                                <?php 
                                                                if(ottieniProvR($cid,$_SESSION["utente"])){ 
																	$value = ottieniProvR($cid,$_SESSION["utente"]);
                                                                    echo "<option value='". $value ."'>". $value  ."</option>";
                                                                }else {
                                                                    echo "<option value='". "provincia" ."'>"."provincia"."</option>";
                                                                }
                                                                while ($row = $resultProvincia->fetch_assoc()) {
                                                                    echo "<option value='" . $row['provincia'] . "'>" . $row['provincia'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
														</div>
														<div class="col-md-4">
															<select class="form-control" id="stato" name="stato">
                                                                <?php
                                                                if(ottieniStatoR($cid,$_SESSION["utente"])){ 
																	$value = ottieniStatoR($cid,$_SESSION["utente"]);
                                                                    echo "<option value='". $value ."'>". $value  ."</option>";
                                                                }else {
                                                                    echo "<option value='". "stato" ."'>"."stato"."</option>";
                                                                }
                                                                
                                                                while ($row = $resultStato->fetch_assoc()) {
                                                                    echo "<option value='" . $row['stato'] . "'>" . $row['stato'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
														</div>
													</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-2 col-sm-offset-5">
                        <button class="btn btn-primary btn-sm" type="button" id="inviaCitta" name="invia">SELEZIONA</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal per l'inserimento dell'immagine -->
<div id="immagineModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form center-block" action = "../backend/uploadImg.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group text-center" style="padding: 10px;">
                        <label for="immagine">Carica un'immagine</label>
                        <input type="file" class="form-control" id="immagine" name="immagine" accept="image/*">                 
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-2 col-sm-offset-5">
                        <input type = "submit" class="btn btn-primary btn-sm" type="button" id="inviaImmagine" name="invia" value = "CARICA IMMAGINE">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle=offcanvas]').click(function () {
            $(this).toggleClass('visible-xs text-center');
            $(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
            $('.row-offcanvas').toggleClass('active');
            $('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
            $('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
            $('#btnShow').toggle();
        });

        $('[data-target="#cittaModal"]').click(function () {
            $.ajax({
                url: '../commons/cittamodal.php',
                type: 'GET',
                success: function (data) {
                    $('#cittaModal').html(data);
                    $('#cittaModal').modal('show');
                },
                error: function () {
                    alert('Errore durante il recupero del contenuto della modale della città.');
                }
            });
        });

        $('[data-target="#immagineModal"]').click(function () {
            $.ajax({
                url: '../commons/immaginemodal.php',
                type: 'GET',
                success: function (data) {
                    $('#immagineModal').html(data);
                    $('#immagineModal').modal('show');
                },
                error: function () {
                    alert('Errore durante il recupero del contenuto della modale dell\'immagine.');
                }
            });
        });

        var savedCitta = "";
        var savedProv = "";
        var savedStato = "";
        var savedNomeFile = "";
        var savedPercorsoFile = "";

        $('#inviaCitta').click(function (e) {
            e.preventDefault();

            var citta = $('#citta').val();
            var prov = $('#prov').val();
            var stato = $('#stato').val();

            // Salva i valori della città, provincia e stato nei campi nascosti
            $('#hiddenCitta').val(citta);
            $('#hiddenProv').val(prov);
            $('#hiddenStato').val(stato);

            // Chiudi la modalità città
            $('#cittaModal').modal('hide');

            // Pulizia campi del modulo città se necessario
            $('#citta').val('');
            $('#prov').val('');
            $('#stato').val('');

            // mostra la modalità post
            $('#postModal').modal('show');
        });

        $('#inviaImmagine').click(function (e) {
			e.preventDefault();

			var inputImmagine = $('#immagine')[0];

			// Verifica se è stato selezionato un file
			if (inputImmagine.files.length > 0) {
				var file = inputImmagine.files[0];

				// Ottiene il nome del file e il percorso del file
				var nomeFile = file.name;
				var percorsoFile = URL.createObjectURL(file); // Otteniamo il percorso temporaneo del file

				$('#hiddenNomeFile').val(nomeFile);
				$('#hiddenPercorsoFile').val(percorsoFile);

				// Chiude e pulisce la modalità immagine
				$('#immagineModal').modal('hide');
				$('#immagine').val('');

				// Mostra la modalità post
				$('#postModal').modal('show');
			} else {
				alert('Per favore, seleziona un\'immagine prima di procedere.');
			}
		});

        // Quando si apre la modalità città, popola i campi con i valori salvati
        $('#cittaModal').on('show.bs.modal', function () {
            $('#citta').val(savedCitta);
            $('#prov').val(savedProv);
            $('#stato').val(savedStato);
        });

        
        $('#inviaPost').click(function () {
            $('#postModal form').submit(); // Invia il form principale
        });

        // Funzione per cambiare il colore del marker
        function changeMarkerColor(citta, prov, stato) {
            var markerIcon = $('.glyphicon-map-marker');
            if (citta) {
                markerIcon.css('color', 'green');
            } else {
                markerIcon.css('color', ''); 
            }
        }
    });
</script>