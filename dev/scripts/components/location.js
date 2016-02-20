function Location () {
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
	var address = {};

	var getAddressWithCEP = function () {
		var service = 'http://apps.widenet.com.br/busca-cep/api/cep.json?code=' + cepField.val();

		request(service, callbackOnCEP);
	};

	var getAddressWithGeolocation = function () {
		navigator.geolocation.getCurrentPosition(function (position) {
			var service = 'http://nominatim.openstreetmap.org/reverse?lat=' + position.coords.latitude + '&lon=' + position.coords.longitude + '&format=json';

			request(service, callbackOnGeolocation);
		});
	};

	var callbackOnCEP = function (data) {
		address = {
			road   : data.address.split(' - ')[0],
			suburb : data.district,
			city   : data.city,
			state  : data.state
		};

		showAddress();
	};

	var callbackOnGeolocation = function (data) {
		address = {
			road   : data.address.road,
			suburb : data.address.suburb,
			city   : data.address.city,
			state  : data.address.state
		};

		showAddress();
	};

	var showAddress = function () {
		alert('Endereço: ' + address.road + ', ' + address.suburb + ', ' + address.city + ' - ' + address.state);
	};

	var request = function (service, callback) {
		$.ajax(service)
		.success(function (data) {
			if(data.status === 0)
				return alert('Endereço não encontrado!');

			callback(data);
		});
	};
	/*=====  End of Methods  ======*/


	/*================================
	=            Triggers            =
	================================*/
	autoLocation.click(getAddressWithGeolocation);
	cepButton.click(getAddressWithCEP);
	/*=====  End of Triggers  ======*/
}