(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		// DOM ready, take it away

		$(window).scrollTop(0);
		$(".wpgmza_sl_radius_div wpgmza-clearfix").hide();
		$(window).scroll(function() {
			if ($(".navbar").offset().top > 35) {
				$(".navbar-fixed-top").addClass("top-nav-collapse"); 
				$(".logo").hide();
				$(".logo-small").show();
				// $(".busca").removeClass('col-md-5');
				// $(".busca").addClass('col-md-3');
				$(".main-nav").hide();
				$(".busca").hide();
				$(".nav-extra-bottom").hide();
				$(".nav-extra").show();
			}
			 else {
				$(".navbar-fixed-top").removeClass("top-nav-collapse");  
				$(".logo").show();
				$(".logo-small").hide();
				$(".main-nav").show();
				$(".busca").show();
				$(".busca").removeClass('col-md-2');
				$(".busca").addClass('col-md-5');
				$(".nav-extra").hide();
				$(".nav-extra-bottom").show();
			}
		});
		
	});
	
})(jQuery, this);
