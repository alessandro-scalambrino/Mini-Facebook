<!DOCTYPE html>
<html lang="en">
<?php include '../commons/header.php';
session_start();

$msg = json_decode($_GET["msg"]);
?>

<body>
    <div class="wrapper">
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">
                <div class="column col-sm-12" id="main">
                    <!-- static navbar -->
                    <?php include '../commons/navbarstatic.php'; ?>
                    <div class="padding">
                        <div class="row">
                            <!-- main col right -->
                            <div class="col-sm-6">
                                <div class="jumbotron text-center">
                                    <div class="well">
                                        <h2 class="text-primary">Benvenuto su MiniFacebook!</h2>
                                        <h4 class="text-muted">Connettiti con milioni di utenti in tutto il mondo!</h4>
                                        <img src="../assets/img/connect.png" alt="connectionlanding" class="img-fluid mt-4">>
                                    </div>
                                </div>
                            </div>
                            <!-- main col left -->
                            <div class="col-sm-6">
                                <div class="jumbotron text-center ">
                                    <div class="well">
                                        <div class="mb-3">
                                            <h2 class="text-primary">Sei già un utente?</h2>
                                            <h4 class="text-muted">Accedi ora!</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="col-md-12 mx-auto" action="../backend/login-exe.php" method="POST" OnSubmit="return formValidation()">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-lg" placeholder="Email" name="email" id="email">
													<span class="formValid" id="emailValid"></span>
													<span class="formInvalid" id="emailInvalid"></span>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control input-lg" placeholder="Password" name="pwd" id="password">
													<span class="formValid" id="passwordValid"></span>
													<span class="formInvalid" id="passwordInvalid"></span>
                                                    <div class = "alert">
                                                        <?php if (isset($msg)) {
                                                            echo $msg;
                                                        }
                                                        ?>
                                                    </div>                                                  
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Accedi">
                                                    <div class="mt-3">
                                                        <span class="float-left"><a href="registrazione.php">Register</a></span>
                                                        <span class="float-right"><a href="#">Need help?</a></span>
                                                    </div>
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
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="../assets/js/formLoginValidation.js"></script>
	
</body>

</html>