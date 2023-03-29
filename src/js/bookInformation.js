// HTML Code to generate and display the generic book information
function displayBookInformation(bookInformation) {
  var title = bookInformation["title"];
  var description = bookInformation["description"];
  if (description == null || description == "") {
    description =
      "We apologize for the lack of a description for this book. However, we are confident that it is an interesting read and encourage you to check it out!";
  }

  var cartButton =
    '<button class="btn btn-secondary mb-3" disabled>Out of Stock</button>';

  var pricePrefix = "";
  var price = "Not Available";
  // If book inventory exists
  var bookInventory = bookInformation["inventory"];
  if (bookInventory != null && bookInventory != "") {
    // Check quantity
    var quantity = bookInventory["quantity"];
    // Quantity exists, and there is books for sale.
    if (quantity != null && quantity != "" && quantity >= 1) {
      price = bookInventory["cost_per_quantity"];
      pricePrefix = "$";
      cartButton =
        '<button class="btn btn-primary mb-3" onclick="addToCart(' +
        bookInformation["id"] +
        ')">Add To Cart</button>';
    }
  }

  // TODO: Pricing
  var html =
    `
    <h1>${title}</h1>
    <p class="lead">${description}</p>
    <p><strong>` +
    pricePrefix +
    price +
    `</strong></p>` +
    cartButton;
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
      '<a href="tagInformation.php?tag=' +
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
      "<a href='authorInformation.php?author=" +
      bookAuthors[i].id +
      "'>" +
      bookAuthors[i].name +
      "</a>";
  }
  html += "</p>";
  document.getElementById("book-info").insertAdjacentHTML("beforeend", html);
}

function displayReviews(bookReviews, reviewDocId) {
  const reviewList = document.querySelector(reviewDocId);
  if (
    bookReviews == undefined ||
    bookReviews == null ||
    bookReviews.length <= 0
  ) {
    const text = document.createElement("p");
    text.innerHTML =
      "There are no reviews for this book.... yet.<br>You can be the first!";
    reviewList.appendChild(text);
    return;
  }

  bookReviews.forEach((review) => {
    // List wrapper
    const li = document.createElement("li");
    li.classList.add("list-group-item");

    // Align to everything to center together with one another,
    const row = document.createElement("div");
    row.classList.add("row", "align-items-center");

    const col1 = document.createElement("div");
    col1.classList.add("col-md-2", "text-center");

    // Add profile picture image, rounded.
    var profilePicSrc = review["profile_picture"];
    // No profile picture, set as default
    if (
      profilePicSrc == undefined ||
      profilePicSrc == null ||
      profilePicSrc == ""
    ) {
      profilePicSrc = "images/genericprofpic.png";
    }
    const profilePic = document.createElement("img");
    profilePic.src = profilePicSrc;
    profilePic.alt = "Reviewer Profile Picture";
    profilePic.classList.add("img-fluid", "rounded-circle", "mb-2");
    col1.appendChild(profilePic);

    // name
    var username = review["username"];
    var userId = review["user_id"];
    if (username == undefined || username == null || username == "") {
      // Likely deleted user
      username = "Deleted User";
      userId = -1;
    }
    const reviewerName = document.createElement("p");
    const reviewerLink = document.createElement("a");
    reviewerLink.textContent = username;
    reviewerLink.href = "userProfile.php?user=" + userId;
    reviewerLink.classList.add(
      "fs-6",
      "fw-bold",
      "text-decoration-none",
      "text-primary"
    );
    reviewerName.appendChild(reviewerLink);
    col1.appendChild(reviewerName);

    // Set col-row for rating stars
    const col2 = document.createElement("div");
    col2.classList.add("col-md-10");
    const row2 = document.createElement("div");
    row2.classList.add("row");
    const col3 = document.createElement("div");
    col3.classList.add("col-md-2", "col-4");

    // Add stars
    const rating = document.createElement("div");
    rating.classList.add("rating", "text-warning", "d-flex", "small");
    for (let i = 0; i < review["rating"]; i++) {
      const star = document.createElement("div");
      star.classList.add("bi-star-fill");
      rating.appendChild(star);
    }
    for (let i = review["rating"]; i < 5; i++) {
      const star = document.createElement("div");
      star.classList.add("bi-star");
      rating.appendChild(star);
    }
    col3.appendChild(rating);

    // rating, but in text
    const ratingText = document.createElement("p");
    ratingText.textContent = review["rating"] + "/5";
    ratingText.classList.add("fw-bold", "mt-2");
    col3.appendChild(ratingText);

    const col4 = document.createElement("div");
    col4.classList.add("col-md-10", "col-8");

    // actually review comment itself
    const content = document.createElement("p");
    content.textContent = review["comment"];
    content.classList.add("mb-0");
    col4.appendChild(content);

    // Small timestamp
    const createdAt = document.createElement("small");
    createdAt.textContent = review["create_at"];
    createdAt.classList.add("text-muted");
    col4.appendChild(createdAt);

    row2.appendChild(col3);
    row2.appendChild(col4);
    col2.appendChild(row2);

    row.appendChild(col1);
    row.appendChild(col2);
    li.appendChild(row);

    reviewList.appendChild(li);
  });
}
