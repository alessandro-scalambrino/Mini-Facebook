function formValidation() {



    isEmailValid = true;
    isPasswordValid = true;

    emailFormat = /^\w+([\.-]?\w+)*@\w+([-]?\w+)*\.\w{2,3}([\.]?\w{2,3})*$/;

    if (document.getElementById("email").value == "") {
        isEmailValid = false;
    } else if (emailFormat.test(document.getElementById("email").value) == false) {
        isEmailValid = false;

    } 
  
    passwordFormat = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;
  
    if (document.getElementById("password").value == "") {
        isPasswordValid = false;
    } else if (passwordFormat.test(document.getElementById("password").value) == false) {
        isPasswordValid = false;
    }
    if (isEmailValid == false || isPasswordValid == false) {
        return false;
    } else {
        return true;
    }
    
}

