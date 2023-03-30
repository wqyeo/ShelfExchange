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
