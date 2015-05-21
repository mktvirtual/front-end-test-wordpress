/** MAINS JS */



/***** STICKY HEADER *******/
$(window).scroll(function() {
if ($(this).scrollTop() > 150){  
    $('.site-header').addClass("sticky");
  }
  else{
  	 $('.site-header').removeClass("sticky");
  }
});