<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Facebook Theme Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/facebook.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
	
	
    <script>
        $(document).ready(function() {
            $('#togglePassword').click(function(){
                var passwordInput = $('#pwd');
                var type = passwordInput.prop('type');
                if (type === 'password') {
                    passwordInput.prop('type', 'text');
                } else {
                    passwordInput.prop('type', 'password');
                }
            });
        });
   
        $(document).ready(function() {
            $('#toggleConfirmPassword').click(function(){
                var confirmPasswordInput = $('#confirmPwd');
                var type = confirmPasswordInput.prop('type');
                if (type === 'password') {
                    confirmPasswordInput.prop('type', 'text');
                } else {
                    confirmPasswordInput.prop('type', 'password');
                }
            });
        });
    </script>
</head>

<body>
    <!-- Includi l'header in ogni pagina -->
    <div class="wrapper">
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">
                <!-- ... Altri elementi dell'header ... -->
            </div>
        </div>
    </div>
</body>

</html>