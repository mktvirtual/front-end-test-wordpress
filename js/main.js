function elId(id) {
	return document.getElementById(id);
}

var map;
function initialize() { 

	var mapOptions = {
		zoom: 18,
		scrollwheel: false
	};
	map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
}
function getLocation() {
	initialize();
	// Tenta utilizar Geolocalização
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = new google.maps.LatLng(position.coords.latitude,
											position.coords.longitude);
			var infowindow = new google.maps.InfoWindow({
				map: map,
				position: pos,
				content: 'Você está aqui!'
			});
			map.setCenter(pos);
		}, function() {
			handleNoGeolocation(true);
		});
	} else {
	// Browser doesn't support Geolocation
		handleNoGeolocation(false);
	}
		  
	function handleNoGeolocation(errorFlag) {
		if (errorFlag) {
			var content = 'Erro: A geolocalização falhou.';
		} else {
			var content = 'Erro: Seu navegador não suporta geolocalização.';
		}
	}
	var options = {
		map: map,
		position: new google.maps.LatLng(60, 105),
		content: content
	};

	var infowindow = new google.maps.InfoWindow(options);
						map.setCenter(options.position);
}

function getCEP(endereco) {
	initialize();
	var geocoder= new google.maps.Geocoder();
	geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();

				console.log('#txtEndereco: ' + results[0].formatted_address);
				console.log('#txtLatitude: ' + latitude);
				console.log('#txtLongitude: ' + longitude);

				var pos = new google.maps.LatLng(latitude, longitude);
				var infowindow = new google.maps.InfoWindow({
					map: map,
					position: pos,
					content: 'Você está aqui!'
				});
				map.setCenter(pos);
		   }
		}
	});
}

jQuery(document).ready(function ($) {

    var $navbar = $("header"),
        y_pos = $navbar.offset().top,
        height = $navbar.height();

    $(document).scroll(function () {
        var scrollTop = $(this).scrollTop();
        //log('scrollTop: ' + scrollTop + '<br> y_pos: ' + y_pos);
        if (scrollTop > y_pos + height) {
            /*$navbar.removeClass('header-top');*/
            $navbar.addClass("header-scroll").animate({ top: 0 });
        } else if (scrollTop <= y_pos) {
            $navbar.removeClass("header-scroll").clearQueue().animate({ top: "-100px" }, 0);
            /*$navbar.addClass('navbar-absolute');*/
        }
    });

    if (typeof $JssorSlider$ != "undefined") {

        var options = {
            $AutoPlay: true,                                   
            $AutoPlayInterval: 4000,                           
            $PauseOnHover: 1,                                  

            $ArrowKeyNavigation: true,                         
            $FillMode: 2,                                      
            $SlideEasing: $JssorEasing$.$EaseOutQuint,         
            $SlideDuration: 800,                               
            $MinDragOffsetToSlide: 20,                         
            //$SlideWidth: 600,                                
            //$SlideHeight: 300,                               
            $SlideSpacing: 0,                                  
            $DisplayPieces: 1,                                 
            $ParkingPosition: 0,                               
            $UISearchMode: 1,                                  
            $PlayOrientation: 1,                               
            $DragOrientation: 1,                               
          
            $BulletNavigatorOptions: {                         
                $Class: $JssorBulletNavigator$,                
                $ChanceToShow: 2,                              
                $AutoCenter: 1,                                
                $Steps: 1,                                     
                $Lanes: 1,                                     
                $SpacingX: 8,                                  
                $SpacingY: 8,                                  
                $Orientation: 1,                               
                $Scale: false                                  
            },

            $ArrowNavigatorOptions: {         
                $Class: $JssorArrowNavigator$,
                $ChanceToShow: 1,             
                $AutoCenter: 2,               
                $Steps: 1                     
            }
    };


    $("#slider_top").css("display", "block");
    var jssor_slider1 = new $JssorSlider$("slider_top", options);

    function ScaleSlider() {
        var bodyWidth = document.body.clientWidth;
        if (bodyWidth)
            jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
        else
            window.setTimeout(ScaleSlider, 30);
    }
    ScaleSlider();

    $(window).bind("load", ScaleSlider);
    $(window).bind("resize", ScaleSlider);
    $(window).bind("orientationchange", ScaleSlider);
	}
});