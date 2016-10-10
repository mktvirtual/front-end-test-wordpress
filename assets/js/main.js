/* Main JS
   ========================================================================== */

(function($, window, undefined) {

	// elements
	var el = {
		infoNav: $(".header__orange-bar__content"),
		btninfoNav: $(".header__orange-bar__info"),
		btnMenu: $(".header__brand__navegation__btn"),
		menu: $('.menu'),
		subMenu: $('.sub-menu'),
		liHasChildrenLink: $('.menu-item-has-children > a'),
		liHasChildren: $('.menu-item-has-children'),
		mapContent : $('.maps__content'),
		cepButton : $('.maps__cep__btn'),
		cepInput : $('.maps__cep__input'),
		headerAlt : $(".header").height()
	}

	// Info Navegation
	el.btninfoNav.on('click', function(event) {
		if (el.infoNav.hasClass('header__orange-bar__content--show')) {
			el.infoNav.removeClass('header__orange-bar__content--show')
			el.btninfoNav.addClass('header__orange-bar__info--close')
		} else {
			el.infoNav.addClass('header__orange-bar__content--show')
			el.btninfoNav.removeClass('header__orange-bar__info--close')
		}
	});
	// Mobile Menu
	el.btnMenu.on('click', function(event) {
		if (el.menu.hasClass('menu--show')) {
			el.menu.removeClass('menu--show')
			el.btnMenu.addClass('header__brand__navegation__btn--active')
		} else {
			el.menu.addClass('menu--show')
			el.btnMenu.removeClass('header__brand__navegation__btn--active')
		}
	});
	// Sub-menu Control
	el.liHasChildrenLink.on('click', function(event) {
		event.preventDefault();
		if (jQuery(this).next().hasClass('sub-menu--active')) {
			jQuery(this).next().removeClass('sub-menu--active');
			jQuery(this).parent().removeClass('menu-item-has-children--active')
		} else {
			jQuery(this).next().addClass('sub-menu--active');
			jQuery(this).parent().addClass('menu-item-has-children--active')
		}
	});
	// Leave mouse menu
	el.liHasChildren.on('mouseleave', function(event) {
		event.preventDefault();
		if (jQuery(this).children(el.subMenu).hasClass('sub-menu--active')) {
			jQuery(this).children(el.subMenu).removeClass('sub-menu--active');
			jQuery(this).removeClass('menu-item-has-children--active')
		}
	});

	//GoElement
	el.headerAlt = el.headerAlt + 40;
	jQuery('.goTo > a').on('click', function(event) {
		event.preventDefault();
		var target = jQuery(this).attr('href');
		console.log(target);
		jQuery('html, body').animate({
			scrollTop: jQuery(target).offset().top - el.headerAlt
		}, 1000)
	});
	// Hide Header on on scroll down
	var didScroll;
	var lastScrollTop = 0;
	var delta = 5;
	var navbarHeight = $('header').outerHeight();

	$(window).scroll(function(event) {
		didScroll = true;
	});

	setInterval(function() {
		if (didScroll) {
			hasScrolled();
			didScroll = false;
		}
	}, 250);
	// Scroll Down Menu
	function hasScrolled() {
		var st = $(this).scrollTop();

		// Make sure they scroll more than delta
		if (Math.abs(lastScrollTop - st) <= delta)
			return;
		// If they scrolled down and are past the navbar, add class .nav-up.
		// This is necessary so you never see what is "behind" the navbar.
		if (st > lastScrollTop && st > navbarHeight) {
			// Scroll Down			
			$('main').removeClass('header--scrollup').addClass('header--scrolldown');
		} else {
			// Scroll Up
			if (st < 200) {
				$('main').removeClass();
			} else if (st + $(window).height() < $(document).height()) {
				$('main').removeClass('header--scrolldown').addClass('header--scrollup');
			}
		}
		lastScrollTop = st;
	}

	$('.maps__my-local').on('click', function(event) {
		getLocation();
	});

	el.cepButton.on('click', function(event) {		
		var cep = el.cepInput.val();
		if (!cep == ""){
			getCEP(cep);
		}
	});


	function getCEP(cep) {
		$.ajax({
			url: 'https://viacep.com.br/ws/'+cep+'/json/',
			success : function(data){
				console.log(data);
				var result = data.logradouro+"+"+data.localidade;
				result = result.split(' ').join('+');
				getLocationGoogle(result)

			}
		});
		
	}

	function getLocationGoogle(result){
		
		$.ajax({
			url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+result+'&key=AIzaSyAw438cDd9LDKOZdD7VXxJKyCCRtzTZet4',
			success : function(data){
				var location = {
					latitude : data.results[0].geometry.location.lat,
					longitude : data.results[0].geometry.location.lng
				};
				initMap(location);			

			}
		});
	}

	function getLocationSucess(pos) {
		var location = pos.coords;
		initMap(location);
	}

	function getLocationError(pos) {
		console.log(pos.coords);

	}

	function getLocation() {
		var options = {
			enableHighAccuracy: true,
			timeout: 5000,
			maximumAge: 0
		}

		navigator.geolocation.getCurrentPosition(getLocationSucess, getLocationError, options)
	}

	function initMap(location) {

		var styles = [{
			stylers: [{
				hue: "#f4deda"
			}, {
				saturation: -20
			}]
		}, {
			featureType: "road",
			elementType: "geometry",
			stylers: [{
				lightness: 100
			}, {
				visibility: "simplified"
			}]
		}, {
			featureType: "road",
			elementType: "labels",
			stylers: [{
				visibility: "off"
			}]
		}];

		var myLatLng = {
			lat: location.latitude,
			lng: location.longitude
		};

		console.log(myLatLng)
;
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 16,
			center: myLatLng,
			styles: styles,
			disableDefaultUI: true,
			scroll: false
		});

		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,		
		});

		el.mapContent.addClass('maps__content--show');

	}


})(jQuery, window);