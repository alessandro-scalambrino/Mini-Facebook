<?php
session_start();
include "../commons/connection.php";
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;

$queryCitta = "SELECT DISTINCT nomeCitta FROM citta";
$resultCitta = $cid->query($queryCitta);

$queryProvincia = "SELECT DISTINCT provincia FROM citta ORDER BY provincia";
$resultProvincia = $cid->query($queryProvincia);

$queryStato = "SELECT DISTINCT stato FROM citta";
$resultStato = $cid->query($queryStato);

$queryHobby = "SELECT DISTINCT nomeHobby FROM  hobby";
$resultHobby = $cid->query($queryHobby);

$queryOrientamento = "SELECT orientamento FROM  orientamentosessuale";
$resultOrientamento = $cid->query($queryOrientamento);

?>


<!DOCTYPE html>
<html lang="en">
<?php 
include '../commons/header.php';
$user =  $_SESSION["utente"];
 ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




<body>

        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">
                <div class="column col-sm-12" id="main">
                    <!-- navbar -->
                    <?php include '../commons/navbar.php'; ?>
					<div class="padding">
                        <div class="card p-4">
                            <div class="jumbotron list-content">
                                <h3 class="text-center">Trova l'amore con il servizio di dating mini-facebook</h4>

                                <!-- Ricerca per Hobby -->
								<form id="formRicercaAvanzata" method="POST">
									<input type="hidden" name="utente_loggato" value="<?php echo $emailUtenteLoggato; ?>">
                                    <div class = "row text-center">
                                        <div class="col-md-4">
                                            <label for="hobby">Hobby:</label>                              
                                        </div>
                                        <div class="col-md-4">
                                            <label for="citta">Città:</label> 
                                        </div>
                                        <div class="col-md-4">
                                            <label for="orientamento">Orientamento sessuale:</label>   
                                        </div>                                           	
									</div>
                                    <div class = "row">
                                        <div class="col-md-4">
                                            <select class = "form-control" name="nomeHobby">
                                            <?php
                                                echo "<option value=''>Seleziona un hobby</option>";
                                                while ($row = $resultHobby->fetch_assoc()) {
                                                    echo "<option value='" . $row['nomeHobby'] . "'>" . $row['nomeHobby'] . "</option>";
                                                }
                                            ?>
                                            </select>                             
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-4">
                                                <select class="form-control" id="cittaR" name="cittaR">
                                                    <?php //codice per popolare il dropdown
                                                    echo "<option value=''>Città</option>"; 
                                                    while ($row = $resultCitta->fetch_assoc()) {
                                                        echo "<option value='" . $row['nomeCitta'] . "'>" . $row['nomeCitta'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control" id="provR" name="provR">
                                                    <?php //codice per popolare il dropdown
                                                    echo "<option value=''>Provincia</option>"; 
                                                    while ($row = $resultProvincia->fetch_assoc()) {
                                                        echo "<option value='" . $row['provincia'] . "'>" . $row['provincia'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control" id="statoR" name="statoR">
                                                    <?php //codice per popolare il dropdown 
                                                    echo "<option value=''>Stato</option>";
                                                    while ($row = $resultStato->fetch_assoc()) {
                                                        echo "<option value='" . $row['stato'] . "'>" . $row['stato'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>														
                                        <div class="col-md-4">
                                            <select class="form-control" id="orientamento" name="orientamento">
                                                <?php //codice per popolare il dropdown 
                                                echo "<option value=''>Orientamento sessuale</option>";
                                                while ($row = $resultOrientamento->fetch_assoc()) {                                            
                                                    echo "<option value='" . $row['orientamento'] . "'>" . $row['orientamento'] . "</option>";
                                                }
                                                ?>
                                            </select>  
                                        </div>                                            	
									</div>
                                    <div class="row text-center">
                                        <div class="col-md-12">
											<input type="button" class="btn btn-primary" name="submit" value="invia" id="btnInviaRicerca">
                                        </div>
                                    </div>                         
								</form>
                                <!-- Sezione Risultati Ricerca -->
                                <div class="mt-4">
                                    <div class="jumbotron list-content">
                                        <h4 class="text-center mb-4">Risultati ricerca</h4>
                                        <ul class="list-group" id="lista-risultati-ricerca">
                                            <!-- Lista dinamica dei risultati della ricerca -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <!--post modal-->
    <?php include '../commons/postmodal.php'; ?>
	<script src="../assets/js/ricerca-avanzata.js"></script>
	<script src="../assets/js/richiesta-amicizia.js"></script>
</body>

</html>
