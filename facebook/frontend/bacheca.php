


<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include '../commons/header.php';
require_once("../commons/funzioni.php"); 
require_once("../commons/connection.php");
// questa bacheca è comune alla navbar e alla ricerca, se ci arrivo dalla ricerca porta alla bacheca dell'utente cercato, d
$emailUtenteLoggato = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;
if (isset($_GET['utente'])) {
    $emailBacheca = $_GET['utente'];
} else {
    $emailBacheca = isset($_SESSION['utente']) ? $_SESSION['utente'] : null;
}



$blocked = isBlocked($cid,$emailUtenteLoggato);
echo $blocked;
$nomeUtente = ottieniNome($cid, $emailBacheca);

?>
<head>
    <!-- js per mostrare i post -->
	<script>
        var emailUtenteLoggato = "<?php echo $emailUtenteLoggato; ?>";
		var emailBacheca = "<?php echo $emailBacheca; ?>";
    </script>
    <script src="../assets/js/showpost-bacheca.js"></script>
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
																<p><strong>Bacheca di <?php echo $nomeUtente; ?></strong></p>
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