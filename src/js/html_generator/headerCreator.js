class HeaderCreator {
  static SEARCH_TITLE = "Find Your Next Favorite Book";
  static SEARCH_PLACEHOLDER = "Search by title, author or genre";

  constructor() {
    document.write(`<header class="bg-dark py-5">`);
  }

  createHeadingWith(title, subtitle) {
    document.write(`
      <div class="container px-4 px-lg-5 my-3 mb-2">
        <div class="text-center text-white">
          <h1 class="display-4 fw-bolder">${title}</h1>
          <p class="lead fw-normal text-white-50 mb-0">${subtitle}</p>
        </div>
      </div>
    `);
  }

  createSearchBar() {
    document.write(`
      <div class="container mb-2 my-4">
        <h2 class="text-white mb-3">${HeaderCreator.SEARCH_TITLE}</h2>
        <form action="search.php" method="GET" class="d-flex">
          <input class="form-control me-2" type="search" placeholder="${HeaderCreator.SEARCH_PLACEHOLDER}" aria-label="Search" name="query">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    `);
  }

  endHeader() {
    document.write(`</header>`);
  }
}
