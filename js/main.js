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

