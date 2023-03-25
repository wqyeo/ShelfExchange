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

function validateUsernameInput(){
    let username = document.getElementById("username");
    
    if (isEmptyOrWhitespace(username.value)) {
        document.getElementById("usernameError").innerHTML = "Username is required. (4 characters long)";
        return false;
    }
    if (username.value.length < 4) {
        document.getElementById("usernameError").innerHTML = "Username must be at least 4 characters long";
        return false;
    }
    
    if (username.value.length > 45) {
        document.getElementById("usernameError").innerHTML = "Username is too long! Maximum 45 characters long";
        return false;
    }
    
    document.getElementById("usernameError").innerHTML = "";
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
    
    if (password.value.length > 255) {
        document.getElementById("usernameError").innerHTML = "Your email shouldn't be this long....";
        return false;
    }
      
    document.getElementById("emailError").innerHTML = "";
    return true;
}

function isEmptyOrWhitespace(str) {
  return (str.trim() === "" || str.length === 0);
}
//endregion

//region Password_Strength_Labelling
// To show password strength bar/label as the user types the password.
document.getElementById("password").addEventListener("input", () => {
  const password = document.getElementById("password").value;
  const strength = calculatePasswordStrength(password);
  
  passwordStrength = document.getElementById("password-strength");
  passwordStrength.style.fontWeight = "bold";
  passwordStrength.textContent = getStrengthLabel(strength);
  
  passwordStrengthBar = document.getElementById("password-strength-bar");
  passwordStrengthBar.style.width = `${strength * 20}%`;
  passwordStrengthBar.className = `progress-bar ${getStrengthColor(strength)}`;
});

// Get password strength value (0-5)
function calculatePasswordStrength(password) {
  var strength = 0;
  if (password.match(/[a-z]+/)) {
    strength += 1;
  }
  
  if (password.match(/[A-Z]+/)) {
    strength += 1;
  }
  
  if (password.match(/[0-9]+/)) {
    strength += 1;
  }
  
  if (password.match(/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]+/)) {
    strength += 1;
  }
  
  if (password.length >= 8) {
    strength += 1;
  }

  if (password.length >= 12) {
    strength += 1;
  }
  
  return strength
}

// Based on (0-5) password strength
function getStrengthLabel(strength) {
  switch (strength) {
    case 1:
      return "Very weak";
    case 2:
      return "Weak";
    case 3:
      return "Fair";
    case 4:
      return "Strong";
    case 5:
      return "Very strong";
    default:
      return "";
  }
}

// Returns a Bootstrap color class that corresponds to the password strength level (0-5)
function getStrengthColor(strength) {
    const strengthLevels = [
    { minScore: 0, class: 'bg-danger' },
    { minScore: 2, class: 'bg-warning' },
    { minScore: 3, class: 'bg-info' },
    { minScore: 4, class: 'bg-success' }
    ];

    // Determine the strength level
    let strengthLevel = 0;
    for (let i = 0; i < strengthLevels.length; ++i) {
        if (strength >= strengthLevels[i].minScore) {
            strengthLevel = i;
        } else {
            break;
        }
    }
    return strengthLevels[strengthLevel].class;
}

//endregion
