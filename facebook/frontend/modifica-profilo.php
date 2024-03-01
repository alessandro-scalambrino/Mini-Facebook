<!DOCTYPE html>
<html lang="en">
<?php 
include '../commons/header.php'; 
include '../commons/connection.php'; 
include '../commons/funzioni.php';
session_start();
$user =  $_SESSION["utente"];
$listaHobby = ottieniHobbyUtente($cid, $user);
if (isset($_GET["msg"])) {
	$msg = unserialize($_GET["msg"]);
}

$queryCitta = "SELECT DISTINCT nomeCitta FROM citta";
$resultCitta = $cid->query($queryCitta);
$queryProvincia = "SELECT DISTINCT provincia FROM citta ORDER BY provincia";
$resultProvincia = $cid->query($queryProvincia);

$queryStato = "SELECT DISTINCT stato FROM citta";
$resultStato = $cid->query($queryStato);

$queryHobby = "SELECT DISTINCT nomeHobby FROM  hobby";
$resultHobby = $cid->query($queryHobby);

$queryOrientamento = "SELECT DISTINCT orientamento FROM  orientamentosessuale";
$resultOrientamento = $cid->query($queryOrientamento);
?>
    
    <body>

			<div class="box">
				<div class="row row-offcanvas row-offcanvas-left">
					

				  

							<div class="column col-sm-12" id="main">
							  	<!--navbar -->
								<?php include '../commons/navbar.php'; ?>
								<div class="row">
								    <div class="well"> 
										   <form action = "../backend/modifica-profilo-exe.php" method = "POST"> 
											  <div class="row">
												 <!-- Colonna 1: Informazioni personali -->
												 <div class="col-md-4 bg-light">
												<h6 class="mt-3 mb-2 text-primary text-center">INFORMAZIONI PERSONALI</h6>

												<div class="form-group">
													<label for="nome">Nome</label>
													<input class="form-control input-lg" placeholder="Nome" type="text" name="Nome" style="border-radius: 10px;" value = <?php echo ottieniNome($cid,$_SESSION["utente"]); ?>>
												</div>

												<div class="form-group">
												<label for="cognome">Cognome</label>
													<input class="form-control input-lg" placeholder="Cognome" type="text" name="Cognome" style="border-radius: 10px;" value = <?php echo ottieniCognome($cid,$_SESSION["utente"]); ?>>
												</div>

												<div class="form-group">
													<label for="dataN">Data di nascita</label>
													<input type="date" class="form-control" name="dataN" style="width: 100%; border-radius: 10px; height: 43px;" value = <?php echo ottieniDataN($cid,$_SESSION["utente"]); ?>>
												</div>
												<div class="form-group">
												<label for="orientamento">Orientamento Sessuale</label>
													<select class="form-control"  name="orientamento">
                                                        <?php //codice per popolare il dropdown 
                                    	                    if(ottieniOrientamento($cid,$_SESSION["utente"])){ 
																$value = ottieniOrientamento($cid,$_SESSION["utente"]);
                                                                    echo "<option value='". $value ."'>". $value  ."</option>";
                                                            }
                                                            while ($row = $resultOrientamento->fetch_assoc()) {
                                                                echo "<option value='" . $row['orientamento'] . "'>" . $row['orientamento'] . "</option>";
                                                            }
                                                        ?>
                                                    </select>
												</div>

												


												<div class="form-group">
													<label for="nomecitta">Città di residenza</label>
													<div class="row">
														<div class="col-md-4">
															<select class="form-control" id="cittaR" name="cittaR">
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
															<select class="form-control" id="provinciaR" name="provinciaR">
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
															<select class="form-control" id="statoR" name="statoR">
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

												<div class="form-group">
													<label for="nomecitta">Città di nascita</label>
													<div class="row">
														<div class="col-md-4">
															<select class="form-control" id="cittaN" name="cittaN">
                                                                <?php 
                                                                if(ottieniCittaN($cid,$_SESSION["utente"])){ 
																	$value = ottieniCittaN($cid,$_SESSION["utente"]);
                                                                    echo "<option value='". $value ."'>". $value  ."</option>";
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
                                                                if(ottieniProvN($cid,$_SESSION["utente"])){ 
																	$value = ottieniProvN($cid,$_SESSION["utente"]);
                                                                    echo "<option value='". $value ."'>". $value  ."</option>";
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
                                                                if(ottieniStatoN($cid,$_SESSION["utente"])){ 
																	$value = ottieniStatoN($cid,$_SESSION["utente"]);
                                                                    echo "<option value='". $value ."'>". $value  ."</option>";
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
													</div>													
												</div>
											</div>
											<!-- Colonna 2: Informazioni di accesso  -->
											<div class="col-md-4 bg-light">
													<h6 class="mt-3 mb-2 text-primary text-center">INFORMAZIONI DI ACCESSO</h6>
													<div class="form-group">
														<label for="email">email</label>
														<input class="form-control input-lg" placeholder="email" type="email" name = "email" style="border-radius: 10px;" value = <?php echo $_SESSION["utente"]?>>
													</div>
													<div class="form-group">
													    <label for="pwd">Password</label>
														<input class="form-control input-lg" placeholder="Cambia Password" type="password" name="pwd" style="border-radius: 10px;" value = <?php echo ottieniPassword($cid,$_SESSION["utente"]); ?>>
													</div>
													<div class="form-group">
														<label for="confirmPwd">Conferma Password</label>
														<input class="form-control input-lg" placeholder="Conferma Password" type="password" name="confirmPwd" style="border-radius: 10px;" value = <?php echo ottieniPassword($cid,$_SESSION["utente"]);?>>
													</div>													
													<div class="text-center" style = "margin-top:300px">					
														<input type="submit" id="submit" name="submit" class="btn btn-primary" value = "INVIA">
													</div>
												 </div>
											</form>	
												 <!-- Colonna 3: sezione hobby -->
												<div class="col-md-4 bg-light">
													<h6 class="mt-3 mb-2 text-primary text-center">HOBBY</h6>
													<label for="hobby">Aggiungi un hobby</label>
													<form action = "../backend/hobby-exe.php" method = "POST">
														<div class="form-group">															
															<div class = "col-md-8">
																<select class = "form-control" name="nomeHobby">
																	<?php
																		while ($row = $resultHobby->fetch_assoc()) {
																			echo "<option value='" . $row['nomeHobby'] . "'>" . $row['nomeHobby'] . "</option>";
																		}
																	?>
																</select>
															</div>
															<div class="form-group text-center col-md-4">
																<input type="submit" name="submit" class="btn btn-primary" value = "aggiungi">
															</div>								
														</div>
														<label>i tuoi hobby:</label>
														<div class = "well">
															<ul>
															<?php
																foreach ($listaHobby["hobby"] as $hobby) {
																	echo "<li>$hobby</li>";
																}
															?>
															</ul>
														</div>														
													</form>
												</div>
											  </div>										   
										  
										
																	  
																			  
																	   </div>
																	  
																	
																	  
																	  
																	</div>
																</div>										  
														</div>
													</div>



		<!--post modal-->
		<?php include '../commons/postmodal.php'; ?>
</body></html>