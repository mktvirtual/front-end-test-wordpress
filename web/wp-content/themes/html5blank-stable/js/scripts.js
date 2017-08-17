(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		// DOM ready, take it away

		$(window).scrollTop(0);
		$(".slide ol > li:first-child").addClass('active');
		$(window).scroll(function() {
			if ($(".navbar").offset().top > 35) {
				$(".navbar-fixed-top").addClass("top-nav-collapse"); 
				$(".logo").hide();
				$(".logo-small").show();
				$(".busca").removeClass('col-md-5');
				$(".busca").addClass('col-md-3');
			} else {
				$(".navbar-fixed-top").removeClass("top-nav-collapse");  
				$(".logo").show();
				$(".logo-small").hide();
				$(".busca").removeClass('col-md-3');
				$(".busca").addClass('col-md-2');
			}
		});
		
	});
	
})(jQuery, this);
