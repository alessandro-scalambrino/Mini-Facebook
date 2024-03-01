<!-- quessta funzione ottiene l'email dell'utente loggato -->
<?php
include '../commons/funzioni.php';
include '../commons/connection.php';


session_start();
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;
$permessi = ottieniPermessi($cid, $emailUtenteLoggato);
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../commons/header.php'; ?>
<?php include '../backend/search.php'; ?>
<?php include '../assets/js/richiesta-amicizia.js'; ?>
<body>
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">
                <!-- main right col -->
                <div class="column col-sm-12" id="main">
                    <!--  navbar -->
                    <?php include '../commons/navbar.php'; ?>
                    <div class="padding">
                        <div class="jumbotron list-content">
                            <ul class="list-group">
                                <?php
                                foreach ($results as $row) {
                                ?>
                                    <li class="list-group-item text-left">
                                    
                                        <label>
                                            <?php echo $row['nome'] . ' ' . $row['cognome']; ?><br>
                                        </label>
										
                                        <label class="pull-right">    
                                            <button onclick="inviaRichiesta('<?php echo $row['email'];?>')" class="btn btn-primary">Aggiungi</button>
											
                                            <?php
												// Visualizza il pulsante "Blocca" solo se l'utente ha il permesso di amministratore
												if ($permessi === 'admin') {
												?>
													<button onclick="bloccaUtente('<?php echo $row['email'];?>')" class="btn btn-primary ">Blocca</button>
												<?php
												}
											?>
											
                                            <a href="bacheca.php?utente=<?php echo urlencode($row['email']); ?>" class="btn btn-primary">Bacheca</a>
                                        </label>
                                        <div class="break"></div>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
					
                    <div id="messaggioRichiestaInviata" style="display: none;" class="alert alert-success">
                        Richiesta inviata con successo!
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <a href="#">Twitter</a> <small class="text-muted">|</small>
                            <a href="#">Facebook</a> <small class="text-muted">|</small>
                            <a href="#">Google+</a>
                        </div>
                        <div class="row" id="footer">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <p><a href="#" class="pull-right">© Copyright 2024</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!--post modal-->
    <?php include '../commons/postmodal.php'; ?>
	
	
</body>

</html>