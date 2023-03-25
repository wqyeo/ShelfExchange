//region Form_Validation
function validateForm() {
    let formIsValid = true;
    
    if (!validateUsernameInput()){
        formIsValid = false;
    }
    if (!validatePasswordInput()){
        formIsValid = false;
    }
    if (!validateEmailInput()){
        formIsValid = false;
    }
    
    return formIsValid;
}

function validatePasswordInput(){
    let password = document.getElementById("password");
    
    if (isEmptyOrWhitespace(password.value)) {
      document.getElementById("passwordError").innerHTML = "Password is required.";
      return false;
    } 
    
    document.getElementById("passwordError").innerHTML = "";
    return true;
}

function validateEmailInput(){
    let email = document.getElementById("email");
    
    // Check if email is valid format
    if (isEmptyOrWhitespace(email.value)) {
        document.getElementById("emailError").innerHTML = "Email is required.";
        return false;
    }
      
    document.getElementById("emailError").innerHTML = "";
    return true;
}

function isEmptyOrWhitespace(str) {
  return (str.trim() === "" || str.length === 0);
}
//endregion
