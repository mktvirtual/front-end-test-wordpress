
	$(document).ready(function(){
		$('#button-01').click(function(){
			$('#panel-01').slideToggle('slow');
		});
		$(window).bind('scroll', function () {
			if ($(window).scrollTop() > 500) {
				$('.nav-edit-slide').removeClass("navbar-edit-absolute").addClass("navbar-edit-fixed");
			} else {
				$('.nav-edit-slide').removeClass("navbar-edit-fixed").addClass("navbar-edit-absolute");
			}
		});
		$('#cepMask').mask("99999-999");
	});
