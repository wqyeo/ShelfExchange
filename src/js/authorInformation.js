function displayTagInformation(authorInformation) {
  document.getElementById("name").innerHTML = authorInformation.name;
  document.getElementById("description").innerHTML =
    authorInformation.description;
}
