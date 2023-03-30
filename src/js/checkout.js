// Get the card number input element
const cardNumberInput = document.getElementById("cardNumber");

// Listen for input events on the card number input
cardNumberInput.addEventListener("input", (e) => {
  // Remove all non-digit characters
  const input = e.target.value.replace(/\D/g, "");

  // Split the input into groups of four digits
  const groups = input.match(/.{1,4}/g);

  // Rejoin the groups with space characters between them
  const formatted = groups ? groups.join(" ") : "";

  // Update the input value with the formatted string
  e.target.value = formatted;
});

function validateForm() {
  var result = true;
  if (!validateEmail()) {
    result = false;
  }
  if (!validateFullName()) {
    result = false;
  }

  if (!validateCardNumber()) {
    result = false;
  }

  if (!validateMainAddress()) {
    result = false;
  }

  if (!validatePostalCode()) {
    result = false;
  }
  if (!validateCardNumber()) {
    result = false;
  }
  if (!validateExpiration()) {
    result = false;
  }
  if (!validateCountry()) {
    result = false;
  }

  return result;
}

function validateFullName() {
  var success = true;
  let nameInput = document.getElementById("fullName").value;

  let errorField = document.getElementById("fullNameError");
  var errorMessage = "";

  if (isEmptyOrWhitespace(nameInput)) {
    errorMessage = "Please enter your full name tied to the card!";
    success = false;
  }

  errorField.innerHTML = errorMessage;
  return success;
}

function validateCardNumber(input) {
  // Remove spaces from input
  const cardNumber = document
    .getElementById("cardNumber")
    .value.trim()
    .replace(/\s+/g, "");
  const cardNumberError = document.getElementById("cardNumberError");
  // Check for non-digit characters
  if (!/^\d+$/.test(cardNumber)) {
    cardNumberError.innerHTML = "Please enter a valid card number!";
    return false;
  }

  // Check that the length is 16 digits
  if (cardNumber.length !== 16) {
    cardNumberError.innerHTML = "Please enter a valid card number!";
    return false;
  }

  // Return the formatted card number
  return true;
}

function validateCountry() {
  const country = document.getElementById("country").value.trim();
  const countryError = document.getElementById("countryError");

  if (country.length === 0) {
    countryError.textContent = "Please enter your country.";
    return false;
  }

  countryError.textContent = "";
  return true;
}

function validatePostalCode() {
  const postalCode = document.getElementById("postalCode").value.trim();
  const postalCodeError = document.getElementById("postalCodeError");

  if (postalCode.length === 0) {
    postalCodeError.textContent = "Please enter your postal code.";
    return false;
  }

  postalCodeError.textContent = "";
  return true;
}

function validateExpiration() {
  const expiration = document.getElementById("expiration").value.trim();
  const expirationError = document.getElementById("expirationError");

  if (expiration.length === 0) {
    expirationError.textContent = "";
    return true;
  }

  const expirationRegex = /^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$/;
  if (!expirationRegex.test(expiration)) {
    expirationError.textContent =
      "Please enter a valid expiration date in MM/YY format.";
    return false;
  }

  expirationError.textContent = "";
  return true;
}

function validateCvv() {
  const cvv = document.getElementById("cvv").value.trim();
  const cvvError = document.getElementById("cvvError");

  if (cvv.length === 0) {
    cvvError.textContent = "";
    return true;
  }

  const cvvRegex = /^\d{3}$/;
  if (!cvvRegex.test(cvv)) {
    cvvError.textContent = "Please enter a valid 3-digit CVV code.";
    return false;
  }

  cvvError.textContent = "";
  return true;
}

function validateMainAddress() {
  var success = true;
  let userInput = document.getElementById("address-one").value;

  let errorField = document.getElementById("addressError");
  var errorMessage = "";

  if (isEmptyOrWhitespace(userInput)) {
    errorMessage = "Please enter your address!";
    success = false;
  }

  errorField.innerHTML = errorMessage;
  return success;
}

function validateEmail() {
  var success = true;
  let userInput = document.getElementById("email").value;

  let errorField = document.getElementById("emailError");
  var errorMessage = "";

  if (isEmptyOrWhitespace(userInput)) {
    // Because email can be left empty;
    errorField.innerHTML = "";
    return true;
  }

  if (!/^\S+@\S+\.\S+$/.test(userInput)) {
    errorMessage = "Invalid email format";
    success = false;
  }

  errorField.innerHTML = errorMessage;
  return success;
}

function isEmptyOrWhitespace(str) {
  return str.trim() === "" || str.length === 0;
}
