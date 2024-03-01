<?php
session_start();
include "../commons/connection.php";
include '../commons/header.php';
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;

$queryUtenti = "SELECT DISTINCT email FROM  utente";
$resultUtenti = $cid->query($queryUtenti);

$user =  $_SESSION["utente"];

$min = json_decode($_GET['min'], true);
$max = json_decode($_GET['max'], true);
$mean = json_decode($_GET['mean'], true);

$top5 = json_decode($_GET["top5"],true);

$blockedMsg = json_decode($_GET["blockedMsg"]);

?>

<!DOCTYPE html>
<html lang="en">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




<body>
    <div class="wrapper">
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">
                <div class="column col-sm-12" id="main">
                    <!-- navbar -->
                    <?php include '../commons/navbar.php'; ?>

                    <div class="padding">
                        <div class="card p-4">
                            <div class="jumbotron list-content">
                                <h3 class="text-center">Strumenti per gli amministratori</h3>	
                                
                                <div class = "well">
                                    <div class = "row text-center">
                                        <div class="col-md-6">
                                            <label>blocca un utente: </label>                              
                                        </div>
                                        <div class="col-md-6">
                                            <label>elimina un utente: </label> 
                                        </div>                                                            	
									</div>
                                    <div class = "row">
                                        <form action = "../backend/blocca-utente.php" method = "POST">
                                            <div class="col-md-6">
                                                <select class = "form-control" name="utenteBlocca">
                                                    <?php
                                                    while ($row = $resultUtenti->fetch_assoc()) {
                                                        echo "<option value='" . $row['email'] . "'>" . $row['email'] . "</option>";
                                                    }
                                                    ?>
                                                </select> 
                                                <div class="row text-center">
                                                    <input type="submit" class="btn btn-primary" name="submit" value="BLOCCA">      
													<a href="lista-utenti-bloccati.php" class="btn btn-link text-primary">Lista Utenti Bloccati</a>
												
                                                </div>
                                                <div>
                                                    <?php
                                                    if (isset($blockedMsg)) {
                                                        echo "<div class = 'alert alert-primary'>".$blockedMsg."</div>";
                                                    }
                                                    ?>
                                                </div>

                                                                          
                                            </div>
                                        </form>                
                                        <form action = "../backend/elimina-utente.php" method = "POST">														
                                        <div class="col-md-6">
                                            <select class="form-control" name="utenteElimina">
                                                <?php //codice per popolare il dropdown 
                                                $resultUtenti->data_seek(0);
                                                while ($row = $resultUtenti->fetch_assoc()) {
                                                    echo "<option value='" . $row['email'] . "'>" . $row['email'] . "</option>";
                                                }
                                                ?>
                                            </select>  
                                            <div class="row text-center">
                                                <input type="submit" class="btn btn-primary" name="submit" value="ELIMINA">                                    
                                            </div> 
                                        </form>                                    
                                    </div>
                                </div>                        
                                <!-- Sezione Risultati Ricerca -->
                                    <div class = "row">
                                        <div class = "row text-center">
                                            <div class="col-md-6">
                                                <label>post caricati da un utente nell'ultima settimana: </label>                              
                                            </div>
                                            <div class="col-md-6">
                                                <label>classifica utenti: </label> 
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <form action = "../backend/statistiche-post-utente.php" method = "POST">
                                                <select class="form-control" name="utentePost">
                                                    <?php //codice per popolare il dropdown 
                                                    $resultUtenti->data_seek(0);
                                                    while ($row = $resultUtenti->fetch_assoc()) {
                                                        echo "<option value='" . $row['email'] . "'>" . $row['email'] . "</option>";
                                                    }
                                                    ?>
                                                </select> 
                                                <div class="row text-center">
                                                    <input type="submit" class="btn btn-primary" name="submit" value="CERCA">                                    
                                                </div>
                                                <div class="row well mt-10">
                                                     <ul class = "">
                                                        <li>numero minimo post: <?php echo $min; ?></li>
                                                        <li>numero massimo post: <?php echo $max; ?></li>
                                                        <li>numero medio post: <?php echo $mean; ?></li>
                                                    </ul>                               
                                                </div>
                                            </form>                            
                                        </div>
                                        <div class="col-md-6">
                                            <form action = "../backend/topFiveCommenti.php" method = "POST">
                                                <div class="row well mt-10" style = "font-size: small;">
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <h4>utente</h4>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <h4>commenti</h4>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <h4>gradimento</h4>
                                                    </div>
                                                    <?php
                                                    if (isset($top5)) {
                                                        for ($i = 0; $i < count($top5); $i++) {
                                                            echo "<div class='col-sm-4'>";
                                                            echo $top5[$i]["Utente"];
                                                            echo "</div>";
                                                            echo "<div class='col-sm-4'>";
                                                            echo $top5[$i]["NumeroCommenti"];
                                                            echo "</div>";
                                                            echo "<div class='col-sm-4'>";
                                                            echo $top5[$i]["GradimentoTotale"];
                                                            echo "</div>";
                                                        }
                                                    }
                                                    ?>
                                                </div>

                                                <div class="row text-center">
                                                    <input type="submit" class="btn btn-primary" name="submit" value="MOSTRA TOP 5 UTENTI">                                    
                                                </div>
                                            </form>   
                                        </div>                                                            	
                                    </div>
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
