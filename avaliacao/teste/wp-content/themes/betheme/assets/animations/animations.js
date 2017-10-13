//	Animations v1.4, Copyright 2014, Joe Mottershaw, https://github.com/joemottershaw/
//	==================================================================================

	// Animate
		function animateElement() {
			if ($(window).width() >= 960) {
				$('.animate').each(function(i, elem) {
					var	elem = $(elem),
						type = $(this).attr('data-anim-type'),
						delay = $(this).attr('data-anim-delay');

					if (elem.visible(true)) {
						setTimeout(function() {
							elem.addClass(type);
						}, delay);
					} 
				});
			} else {
				$('.animate').each(function(i, elem) {
					var	elem = $(elem),
						type = $(this).attr('data-anim-type'),
						delay = $(this).attr('data-anim-delay');

						setTimeout(function() {
							elem.addClass(type);
						}, delay);
				});
			}
		}

		$(document).ready(function() {
			if ($('html').hasClass('no-js'))
				$('html').removeClass('no-js').addClass('js');

			animateElement();
		});

		$(window).resize(function() {
			animateElement();
		});

		$(window).scroll(function() {
			animateElement();

			if ($(window).scrollTop() + $(window).height() == $(document).height())
				animateElement();
		});

	// Triggers
		function randomClass() {
			var	random = Math.ceil(Math.random() * classAmount)

			return classesArray[random];
		}

		function animateOnce(target, type) {
			if (type == 'random')
				type = randomClass();

			$(target).removeClass('trigger infinite ' + triggerClasses).addClass('trigger').addClass(type).one('webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend', function() {
				$(this).removeClass('trigger infinite ' + triggerClasses);
			});
		}

		function animateInfinite(target, type) {
			if (type == 'random')
				type = randomClass();

			$(target).removeClass('trigger infinite ' + triggerClasses).addClass('trigger infinite').addClass(type).one('webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend', function() {
				$(this).removeClass('trigger infinite ' + triggerClasses);
			});
		}

		function animateEnd(target) {
			$(target).removeClass('trigger infinite ' + triggerClasses);
		}

	// Variables
		var	triggerClasses = 'flash strobe shakeH shakeV bounce tada wave spinCW spinCCW slingshotCW slingshotCCW wobble pulse pulsate heartbeat panic',
			classesArray = new Array,
			classesArray = triggerClasses.split(' '),
			classAmount = classesArray.length;