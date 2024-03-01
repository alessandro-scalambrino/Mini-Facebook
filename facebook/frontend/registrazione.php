<!DOCTYPE html>
<html lang="en">
<?php 
include '../commons/header.php'; 
include '../commons/connection.php'; //connessione al database per popolare i dropdown
$errore = array();
if (isset($_GET["status"]))
{ 
  if ($_GET["status"]=="ko"){
    $errore = unserialize($_GET["errore"]);
    $dati = unserialize($_GET["dati"]);
  }
  print_r($dati);
}
?>
    
<body>
    <div class="wrapper">
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">
                <div class="column col-sm-12" id="main">
                    <!--static navbar -->
                    <?php include '../commons/navbarstatic.php'; ?>
                    <div class="padding">
                        <div class="full col-sm-9">                   
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">                           
                                    <div class="well"> 
                                        <form action="../backend/registrazione-exe.php" method="POST">
                                            
                                            <div class="input-group text-center">
                                                <h6 class="mt-3 mb-2 text-primary" style="text-align: center">INFORMAZIONI DI ACCESSO</h6>
                                                <div style="padding: 10px;">
                                                    <input class="form-control input-lg" placeholder="email" type="email" style="border-radius: 10px;" id="email" name="email" value = <?php if(isset($_GET["status"])) echo $dati["email"]; ?>>
                                                </div>
                                                <div style="padding: 10px;">
                                                    <input class="form-control input-lg" placeholder="Password" type="password" id="pwd" style="border-radius: 10px;" name="pwd" value = <?php if(isset($_GET["status"])) echo $dati["pwd"]; ?>>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="togglePassword" style="cursor: pointer; position: absolute; top: 16.5%; right: 25px; transform: translateY(-50%);">
                                                            <i class="fas fa-eye"></i> 

                                                        </span>
                                                        <?php 
                                                            if (isset($errore["passFormat"])) {
                                                                echo "<span class = 'errore '>".$errore["passFormat"]."</span>";
                                                            }
                                                     ?>
                                                        
                                                    </div>
                                                </div>
                                                <div style="padding: 10px;">
                                                    <input class="form-control input-lg" placeholder="Conferma Password" type="password" id="confirmPwd" style="border-radius: 10px;" name="confirmPwd" value = <?php if(isset($_GET["status"])) echo $dati["confirmPwd"]; ?>>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="toggleConfirmPassword" style="cursor: pointer; position: absolute; top: 26%; right: 25px; transform: translateY(-50%);">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                        <?php
                                                        if (isset($errore["passNotSame"])) {
                                                            echo "<span class = 'errore'>".$errore["passNotSame"]."</span>";
                                                        }
                                                     ?>
                                                    </div>
                                                </div>
                                                <h6 class="mt-3 mb-2 text-primary" style="text-align: center">INFORMAZIONI ANAGRAFICHE</h6>
                                                <div style="padding: 10px;">
                                                    <input class="form-control input-lg" placeholder="Nome" type="text" style="border-radius: 10px;" id="nome" name="nome" value = <?php if(isset($_GET["status"])) echo $dati["nome"]; ?>>
                                                </div>
                                                <div style="padding: 10px;">
                                                    <input class="form-control input-lg" placeholder="Cognome" type="text" style="border-radius: 10px;" id="cognome" name="cognome" value = <?php if(isset($_GET["status"])) echo $dati["cognome"]; ?>>
                                                </div>
                                                <div style="padding: 10px;">
                                                    <input class="form-control input-lg" placeholder="Data di Nascita" type="date" style="border-radius: 10px;" id="dataN" name="dataN" max ="2005-01-01" value = <?php if(isset($_GET["status"])) echo $dati["dataN"]; ?>>
                                                </div>


                                                <?php
                                                // Recupera i dati per i dropdown
                                                $queryCitta = "SELECT DISTINCT nomeCitta FROM citta";
                                                $resultCitta = $cid->query($queryCitta);

                                                $queryProvincia = "SELECT DISTINCT provincia FROM citta ORDER BY provincia";
                                                $resultProvincia = $cid->query($queryProvincia);

                                                $queryStato = "SELECT DISTINCT stato FROM citta";
                                                $resultStato = $cid->query($queryStato);
                                                ?>

                                                <div class="form-group" style="padding: 10px;">
                                                    <label for="nomecitta" >Città di residenza</label>
                                                    <div class="row">
                                                        <div class="col-md-4">                                   
                                                            <select class="form-control" id="cittaR" name="cittaR">
                                                                <?php //codice per popolare il dropdown 
                                                                if(isset($_GET["status"])){ //tengo traccia dell'input nel caso di errori per evitare che l'utente debba reinserire tutti i campi 
                                                                    echo "<option value='". $dati["cittaR"] ."'>". $dati["cittaR"]  ."</option>";
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
                                                            <select class="form-control" id="provinciaR" name="provinciaR">
                                                                <?php 
                                                                if(isset($_GET["status"])){ 
                                                                    echo "<option value='". $dati["provinciaR"] ."'>". $dati["provinciaR"]  ."</option>";
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
                                                            <select class="form-control" id="statoR" name="statoR">
                                                                <?php
                                                                if(isset($_GET["status"])){ 
                                                                    echo "<option value='". $dati["statoR"] ."'>". $dati["statoR"]  ."</option>";
                                                                }else {
                                                                    echo "<option value='". "stato" ."'>"."stato"."</option>";
                                                                }
                                                                
                                                                while ($row = $resultStato->fetch_assoc()) {
                                                                    echo "<option value='" . $row['stato'] . "'>" . $row['stato'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <?php
                                                        if (isset($errore["validCittaR"])) {
                                                            echo "<span class = 'errore'>".$errore["validCittaR"]."</span>";
                                                        }
                                                     ?>
                                                    </div>
                                                </div>
												<div class="form-group" style="padding: 10px;">
                                                    <label for="nomecitta">Città di nascita</label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <select class="form-control" id="cittaN" name="cittaN">
                                                                <?php 
                                                                if(isset($_GET["status"])){ 
                                                                    echo "<option value='". $dati["cittaN"] ."'>". $dati["cittaN"]  ."</option>";
                                                                }else {
                                                                    echo "<option value='". "città" ."'>"."città"."</option>";
                                                                }
                                                                $resultCitta->data_seek(0); 
                                                                while ($row = $resultCitta->fetch_assoc()) {
                                                                    echo "<option value='" . $row['nomeCitta'] . "'>" . $row['nomeCitta'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">                 
                                                            <select class="form-control" id="provinciaN" name="provinciaN">
                                                                <?php 
                                                                if(isset($_GET["status"])){ 
                                                                    echo "<option value='". $dati["provinciaN"] ."'>". $dati["provinciaN"]  ."</option>";
                                                                }else {
                                                                    echo "<option value='". "provincia" ."'>"."provincia"."</option>";
                                                                }
                                                                $resultProvincia->data_seek(0);
                                                                while ($row = $resultProvincia->fetch_assoc()) {
                                                                    echo "<option value='" . $row['provincia'] . "'>" . $row['provincia'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-control" id="statoN" name="statoN" placeholder = "stato">
                                                                <?php
                                                                if(isset($_GET["status"])){ 
                                                                    echo "<option value='". $dati["statoN"] ."'>". $dati["statoN"]  ."</option>";
                                                                }else {
                                                                    echo "<option value='". "stato" ."'>"."stato"."</option>";
                                                                }
                                                                $resultStato->data_seek(0);
                                                                while ($row = $resultStato->fetch_assoc()) {
                                                                    echo "<option value='" . $row['stato'] . "'>" . $row['stato'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <?php
                                                        if (isset($errore["validCittaN"])) {
                                                            echo "<span class = 'errore'>".$errore["validCittaN"]."</span>";
                                                        }
                                                     ?>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="padding: 10px;">
                                                    <?php
                                                        if (isset($errore["emptyFields"])) {
                                                            echo "<span class = 'errore'>".$errore["emptyFields"]."</span>";
                                                        }
                                                     ?>
                                                </div>

                                                <div class="input-group text-center col-sm-4 col-sm-offset-4">
                                                    <ul class="list-inline d-block">
                                                        <li class="input-btn" style="padding: 10px;">
                                                            <input type="submit" class="btn btn-lg btn-primary" name="signup" value = "INVIA">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!--/row-->
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="#">Twitter</a> <small class="text-muted">|</small> <a href="#">Facebook</a> <small class="text-muted">|</small> <a href="#">Google+</a>
                                </div>
                            </div>
                            
                            <div class="row" id="footer">    
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <p>
                                        <a href="#" class="pull-right">© Copyright 2024</a>
                                    </p>
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
</body>
</html>
