// HTML Code to generate and display the generic book information
function displayBookInformation(bookInformation) {
  var title = bookInformation["title"];
  var description = bookInformation["description"];
  if (description == null || description == ""){
    description = "We apologize for the lack of a description for this book. However, we are confident that it is an interesting read and encourage you to check it out!";
  }
  // TODO: Pricing
  const html = `
    <h1>${title}</h1>
    <p class="lead">${description}</p>
    <p><strong>Price:</strong> $10.00</p>
    <button class="btn btn-primary mb-3">Add to Cart</button>
  `;
  document.getElementById("book-info").insertAdjacentHTML("beforeend", html);
}

function displayBookTags(bookTags) {
  var html = "<p><strong>Tags:</strong> ";
  for (var i = 0; i < bookTags.length; ++i) {
    // Comma seperate
    if (i > 0) {
      html += ", ";
    }
    // Append tag name,
    // Href to tag information when clicked on.
    html +=
      '<a href="tagInformation?tag=' +
      bookTags[i].id +
      '">' +
      bookTags[i].name +
      "</a>";
  }
  html += "</p>";
  
  document.getElementById("book-info").insertAdjacentHTML("beforeend", html);
}

// HTML Code to generate and display list of book authors.
function displayBookAuthors(bookAuthors) {
  var html = "<p><strong>Author(s):</strong> ";
  for (var i = 0; i < bookAuthors.length; ++i) {
    if (i > 0) {
      html += ", ";
    }
    html +=
      "<a href='authorInformation?author=" +
      bookAuthors[i].id +
      "'>" +
      bookAuthors[i].name +
      "</a>";
  }
  html += "</p>";
  document.getElementById("book-info").insertAdjacentHTML("beforeend", html);
}
