jQuery(document).ready(function () {
  jQuery('.top-bar-section li a').click(function (event) {
    var esse = jQuery(this);
    jQuery(".active").removeClass("active");
    esse.closest('li').toggleClass('active');
    jQuery.scrollTo(this.hash, 600, {offset: function() { return {top:-50, left:-5}; }});
  });
});