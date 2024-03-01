<?php
session_start();
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;

?>


<!DOCTYPE html>
<html lang="en">
<?php include '../commons/header.php';
require_once("../commons/funzioni.php"); 
require_once("../commons/connection.php");
$blocked = isBlocked($cid,$emailUtenteLoggato);
echo $blocked;
?>
<head>
    <!-- js per mostrare i post -->
	<script>
        var emailUtenteLoggato = "<?php echo $emailUtenteLoggato; ?>";
    </script>
    <script src="../assets/js/showpost.js"></script>
</head>	
    <body>
        

			<div class="box">
				<div class="row row-offcanvas row-offcanvas-left">
					

				  

						<div class="column col-sm-12" id="main">
							<!-- navbar -->
						<?php include '../commons/navbar.php'; ?>                   
								<div class="row">										
									<div class="padding">
										<div class = "col-md-8 col-md-offset-2">
											<div class="jumbotron list-content">
												<ul class="list-group" style="list-style-type: none;">
												<?php 
													if (isset($blocked)) {
														if ($blocked == "si") {
															echo '<li>';
															echo '<div class="alert alert-danger alert-dismissable">';
															echo 'Il tuo account è stato bloccato. Non puoi interagire con gli altri utenti.';
															echo '</div>'; 
															echo '</li>';
														}
													}
												?>

													<li>
														<div class = "panel panel-default col-sm-10 col-sm-offset-1">
															<div class="panel-heading">
																<p><strong>Benvenuto su MiniFacebook!</strong></p>
															</div>
															<div class="panel-body with-margin-bottom">
																<p>alcuni suggerimenti:</p>
																<ul>
																	<li>aggiungi i tuoi amici cercandoli e inizia a interagire!</li>
																	<li>vuoi conoscere persone con i tuoi interessi? usa la sezione "trova l'amore".</li>
																	<li>fai sapere a tutti a cosa stai pensando, clicca il tasto post!</li>
																	<li>dicci di più su di te, aggiungi informazioni tramite la sezione modifica profilo.</li>
																</ul>
															</div>
														</div>
													</li>
												</ul>	
												<ul class="list-group" id="lista-post">
													<!-- Lista dinamica dei post -->
												</ul>											
											</div>		
										</div>								  										  
									</div>
							   </div>
							   
							  
								<div class="row">
								  <div class="col-sm-6">
									<a href="#">Twitter</a> <small class="text-muted">|</small> <a href="#">Facebook</a> <small class="text-muted">|</small> <a href="#">Google+</a>
								  </div>
								</div>
							  
								<div class="row" id="footer">    
								  <div class="col-sm-6">
									
								  </div>
								  <div class="col-sm-6">
									<p>
									<a href="#" class="pull-right">�Copyright 2024</a>
									</p>
								  </div>
								</div>
							  
							  <hr>
							  
							  <h4 class="text-center"> </h4>
								
							  <hr>
								
							  
						</div>
				</div>
			</div>

		<!--post modal-->
		<?php include '../commons/postmodal.php'; ?>
		<?php include '../commons/blockedModal.php'; ?>
</body></html>