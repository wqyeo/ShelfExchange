const CART_LIST_COOKIE_NAME = "userCarts";

function addToCart(bookId) {
  let cartArray = getCartsArray();

  // Already exists in cart.
  if (cartArray.some((el) => el === bookId)) {
    return;
  }

  cartArray.push(bookId);
  saveCartsArray(cartArray);
  showCartCount();

  var cartBtn = document.getElementById("cart-btn-" + bookId);
  if (cartBtn != null) {
    cartBtn.innerHTML = "In Cart";
    cartBtn.classList.add("btn-secondary");
    cartBtn.classList.add("text-white");
    cartBtn.disabled = true;
  }
}

function removeFromCart(bookId) {
  let cartArray = getCartsArray();
  if (!cartArray.some((el) => el === bookId)) {
    // Doesnt exist to remove
    return;
  }

  var elementIndex = cartArray.indexOf(bookId);
  cartArray.splice(elementIndex, 1);
  saveCartsArray(cartArray);

  var cartElement = document.getElementById("book-cart-element-" + bookId);
  if (cartElement != null) {
    cartElement.remove();
  }

  if (cartArray.length <= 0) {
    var checkoutBtn = document.getElementById("checkout-btn");
    if (checkoutBtn != null) {
      checkoutBtn.classList.remove("btn-success");
      checkoutBtn.classList.add("btn-secondary");
      checkoutBtn.classList.add("text-white");
      checkoutBtn.disabled = true;
      checkoutBtn.innerHTML = "No Items in Cart";
    }
  }
}
function setCheckoutState() {
  var cartArray = getCartsArray();
  if (cartArray.length <= 0) {
    var checkoutBtn = document.getElementById("checkout-btn");
    if (checkoutBtn != null) {
      checkoutBtn.classList.remove("btn-success");
      checkoutBtn.classList.add("btn-secondary");
      checkoutBtn.classList.add("text-white");
      checkoutBtn.disabled = true;
      checkoutBtn.innerHTML = "No Items in Cart";
    }
  }
}

function saveCartsArray(cartsArray) {
  document.cookie = CART_LIST_COOKIE_NAME + "=" + JSON.stringify(cartsArray);
}

function setCartButtonStates() {
  let cartsArray = getCartsArray();
  for (var i = 0; i < cartsArray.length; i++) {
    var currentBookId = cartsArray[i];
    var cartBtn = document.getElementById("cart-btn-" + currentBookId);
    if (cartBtn != null) {
      cartBtn.innerHTML = "In Cart";
      cartBtn.classList.add("btn-secondary");
      cartBtn.classList.add("text-white");
      cartBtn.disabled = true;
    }
  }
}

function getCartsArray() {
  let cookieString = document.cookie;
  let cookieArray = cookieString.split(";");
  let myArrayString = cookieArray.find((c) =>
    c.includes(CART_LIST_COOKIE_NAME + "=")
  );

  let myArray;
  if (myArrayString) {
    myArray = JSON.parse(
      myArrayString.replace(CART_LIST_COOKIE_NAME + "=", "")
    );
  } else {
    myArray = [];
  }
  return myArray;
}

function showCartCount() {
  var cartCount = getCartsArray().length;
  document.getElementById("cart-count").innerHTML = cartCount;
}
