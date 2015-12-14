
jQuery(document).ready(function(){       
  var scroll_start = 0;
  var startchange = jQuery('#startchange');
  var offset = startchange.offset();
  if (startchange.length){
    jQuery(document).scroll(function() { 
      scroll_start = jQuery(this).scrollTop();
      if(scroll_start > offset.top) {
        jQuery(".navbar").css('background-color', '#fff');
        jQuery(".navbar-sup").css('background-color', '#d1d3d4');
        jQuery(".search-form, .search-field, .search-submit").css('background-color', '#949697');
        jQuery(".navbar-sup a").css('color', '#58595b');
        jQuery(".navbar-brand > img").css('max-height', '40px');
      } else {
        jQuery('.navbar').css('background-color', 'transparent');
        jQuery(".navbar-sup").css('background-color', '#F57D31');
        jQuery(".search-form, .search-field, .search-submit").css('background-color', '#C66224');
        jQuery(".navbar-sup a").css('color', '#FFF');
        jQuery(".navbar-brand > img").css('max-height', 'auto');
      }
        if(scroll_start > 400) {
          jQuery(".navbar").css('margin-top', '0');
          jQuery(".navbar-sup").css('top', '-31');
      } else {
        jQuery(".navbar").css('margin-top', '29px');
        jQuery(".navbar-sup").css('top', '0');
      }
    });
  }
});