
//region Form_Validation
function validateForm() {
    let formIsValid = true;
    
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
      document.getElementById("passwordError").innerHTML = "Password is required. (8 characters long)";
      return false;
    } 
    // Need at least 8 characters long
    if (password.value.length < 8) {
      document.getElementById("passwordError").innerHTML = "Password must be at least 8 characters long";
      return false;
    }
    
    if (password.value.length > 64) {
      document.getElementById("passwordError").innerHTML = "Password is too long! Maximum 64 characters";
      return false;
    }
    
    document.getElementById("passwordError").innerHTML = "";
    return true;
}

function validateEmailInput(){
    let email = document.getElementById("email");
    
    // Check if email is valid format
    if (isEmptyOrWhitespace(email.value)) {
        document.getElementById("emailError").innerHTML = "Email is required";
        return false;
    }
    if (!/^\S+@\S+\.\S+$/.test(email.value)) {
        document.getElementById("emailError").innerHTML = "Invalid email format";
        return false;
    }
      
    document.getElementById("emailError").innerHTML = "";
    return true;
}

function isEmptyOrWhitespace(str) {
  return (str.trim() === "" || str.length === 0);
}
//endregion

