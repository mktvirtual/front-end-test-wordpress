document.addEventListener("DOMContentLoaded", function(event) {
(function () {
  var body = document.querySelectorAll('body')[0],
      menuAnchor = document.querySelectorAll('.menu-anchor')[0],
      dropdownAnchor = document.querySelectorAll('.anchor-dropdown')[0],
      dropdownAnchorBack = document.querySelectorAll('.anchor-dropdown-back')[0],
      AnchorSearch = document.querySelectorAll('.search-anchor')[0],
      AnchorSearchBack = document.querySelectorAll('.btn-Search-close')[0],
      prevEvent = false,

      toggleHTMLClass = function (event) {
        event.stopPropagation();
        event.preventDefault();
        if (!prevEvent) {
          prevEvent = true;

          setTimeout(function () {
            prevEvent = false;
          }, 500);
        }
      };

  menuAnchor.addEventListener('click', function(toggleHTMLClass){
    body.classList.toggle('menu-active');
  });
  dropdownAnchor.addEventListener('click', function(toggleHTMLClass){
    body.classList.toggle('dropdown-active');
  });
  dropdownAnchorBack.addEventListener('click', function(toggleHTMLClass){
    body.classList.toggle('dropdown-active');
  });

  AnchorSearch.addEventListener('click', function(toggleHTMLClass){
    body.classList.toggle('search-active');
  });

  AnchorSearchBack.addEventListener('click', function(toggleHTMLClass){
    body.classList.toggle('search-active');
  });
})();

});
