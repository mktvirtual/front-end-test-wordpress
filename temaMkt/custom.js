
jQuery(document).ready(function(){

	jQuery(".btn-nav").click(function(){

		jQuery("header").slideToggle(400, function(){

			jQuery(this).toggleClass("nav-expandido").css('display', '');

			});

	});

});

jQuery(document).ready(function(){

	jQuery(".btn-menu").click(function(){

		jQuery(".main-menumobile").slideToggle(400, function(){

			jQuery(this).toggleClass("nav-expandido").css('display:block', '');

			});

	});

});