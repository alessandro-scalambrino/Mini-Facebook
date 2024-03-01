<?php 

include_once '../commons/funzioni.php';
require_once('../commons/connection.php');
session_start();
$modal = "#postModal";
if (isBlocked($cid,$_SESSION["utente"]) == "si") {
    $modal = "#blockedModal";
}
?>
    <div class="navbar navbar-blue navbar-static-top">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="home-page.php" class="navbar-brand logo">Mf</a>
        </div>
        <nav class="collapse navbar-collapse" role="navigation">
            <form class="navbar-form navbar-left" action="../frontend/risultati-ricerca.php" method="get">
				<div class="input-group input-group-sm" style="max-width:360px;">
					<input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
			</form>
		<ul class="nav navbar-nav navbar-right">
            <ul class="nav navbar-nav">
                <li>
                    <a href="home-page.php"><i class="glyphicon glyphicon-home"></i> Home</a>
                </li>
				<li>
                    <a href="bacheca.php"><i class="glyphicon glyphicon-user"></i> La tua bacheca</a>
                </li>
				<li>
                    <a href="ricerca-avanzata.php"><i class="glyphicon glyphicon-heart"></i> Trova l'amore</a>
                </li>
                <li>
                   
                    <a href="<?php echo $modal?>" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Post</a>
                </li>
				<li>
					<a href="richieste-di-amicizia.php" role="button" ><i class="glyphicon glyphicon-envelope"></i> Richieste di amicizia</a>
                    
                </li>
				<li>
                    <a href="lista-amici.php" role="button" ><i class="glyphicon glyphicon-list-alt"></i> Lista amici</a>
                </li>
                
            </ul>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-align-justify"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="modifica-profilo.php">Modifica profilo</a></li>
                    <?php 
                    require("../commons/connection.php");
                    if(ottieniPermessi($cid,$_SESSION["utente"]) == "admin"){
                        echo "<li>";
                        echo "<a href='vista-admin.php'>";
                        echo "strumenti dell'amministratore</a>"; 
                        echo "</li>";           
                    }
                ?>	
                    <li><a href="index.php">Logout</a></li>
                    
                </ul>
            </li>
        </ul>

        </nav>
    </div>
