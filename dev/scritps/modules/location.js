function Location() {
	'use strict';

	/*==================================
	=            References            =
	==================================*/
	var cepField	 = $('#cep-field'),
		cepButton	 = $('#cep-button'),
		autoLocation = $('#auto-location');
	/*=====  End of References  ======*/


	/*===============================
	=            Methods            =
	===============================*/
	var getAddressWithCEP= function () {
		var service = 'http://apps.widenet.com.br/busca-cep/api/cep.json?code=' + cepField.val();

		request(service);
	};

	var getAddressWithGeolocation = function () {
		navigator.geolocation.getCurrentPosition(function (position) {
			var service = 'http://nominatim.openstreetmap.org/reverse?lat=' + position.coords.latitude + '&lon=' + position.coords.longitude + '&format=json';

			request(service);
		});
	};

	var request = function (service) {
		$.ajax(service).
		success(function (data) {
			alert(JSON.stringify(data));
		});
	};
	/*=====  End of Methods  ======*/


	/*================================
	=            Triggers            =
	================================*/
	cepButton.click(getAddressWithCEP);
	autoLocation.click(getAddressWithGeolocation);
	/*=====  End of Triggers  ======*/
}