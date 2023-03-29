const CART_LIST_COOKIE_NAME = "userCarts";

function addToCart(bookId) {
  let cartArray = getCartsArray();

  // Already exists in cart.
  if (cartArray.some((el) => el === bookId)) {
    return;
  }

  cartArray.push(bookId);
  saveCartsArray(cartArray);
}

function saveCartsArray(cartsArray) {
  document.cookie = CART_LIST_COOKIE_NAME + "=" + JSON.stringify(cartsArray);
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
