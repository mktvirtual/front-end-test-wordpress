function Banners () {
	"use strict";

	/*==================================
	=            References            =
	==================================*/
	var banners = $("#banners");
	/*=====  End of References  ======*/


	/*===============================
	=            Methods            =
	===============================*/
	this.pauseSlider = function () {
		banners.slick("slickPause");
	};

	this.playSlider = function () {
		banners.slick("slickPlay");
	};

	var settings = function () {
		return {
			adaptiveHeight : true,
			autoplay    : true,
			dots        : true,
			mobileFirst : true
		};
	};
	/*=====  End of Methods  ======*/


	/*================================
	=            Triggers            =
	================================*/
	banners.slick(settings());
	/*=====  End of Triggers  ======*/
}