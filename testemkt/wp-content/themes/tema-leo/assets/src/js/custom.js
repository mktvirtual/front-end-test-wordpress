

//SCROLLBAR
$(function() {
	$('.go').click(function() {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top
				}, 600);
				return false;
			}
		}
	});
});

  //MENU FIXED

  if ($(window).width() > 1300) {
  	$(window).bind('scroll', function () {
  		if ($(window).scrollTop() > 10) {
  			$('.main-header').addClass("header-mobile");
  		}
  		else{
  			$('.main-header').removeClass('header-mobile');
  		}
  	});
  }


  $(window).bind('scroll', function () {
  	if ($(window).scrollTop() > 10) {
  		$('#upArrow').css("bottom","20px");
  	}
  	else{
  		$('#upArrow').css("bottom","-50px");
  	}
  });



//MENU RESIZE ON MOBILE
if ($(window).width() < 1300) {
	$('.main-header').addClass("header-mobile");
}
else {
	$('.main-header').removeClass('header-mobile');
}






//SUBMENU

function menuAction(){
	$('.dropdown-button').removeClass('open');
	$('.overlay').toggleClass('overlay-slide'); 
	$('.dropdown-open').prop('checked', false);
} 

$('.dropdown-button').click(function(){
	$(this).toggleClass('open'); 
});


$('.drop-trigger').click(function(){
	$('.overlay').toggleClass('overlay-slide'); 
});


$('.overlay').click(function(){
	menuAction();
});

document.addEventListener('keyup', function(e){
    if(e.keyCode == 27) {
        if($('.drop-trigger').hasClass('open')){
			menuAction();
        }
    }
});





//PREVENT DOUBLE CLICK
$(document).ready(function(){
	$('.menu-link').dblclick(function(e){
		e.preventDefault();
	});
});

//CUSTOM SLIDER

$(function() {
	var slider = $("#slider").slippry({
		// transition: 'fade',
		// useCSS: true,
		// speed: 1000,
		// pause: 3000,
		// auto: true,
		// preload: 'visible',
		// autoHover: false
	});

	$('.stop').click(function () {
		slider.stopAuto();
	});

	$('.start').click(function () {
		slider.startAuto();
	});

	$('.prev').click(function () {
		slider.goToPrevSlide();
		return false;
	});
	$('.next').click(function () {
		slider.goToNextSlide();
		return false;
	});
	$('.reset').click(function () {
		slider.destroySlider();
		return false;
	});
	$('.reload').click(function () {
		slider.reloadSlider();
		return false;
	});
	$('.init').click(function () {
		slider = $("#slider").slippry();
		return false;
	});
});


