function Menu () {
	"use strict";

	/*==================================
	=            References            =
	==================================*/
	var menu = $("#menu"),
		base = $("#base");

	var inMenuShow,
		inMenuHide;
	/*=====  End of References  ======*/


	/*===============================
	=            Methods            =
	===============================*/
	this.inputer = function (callInMenuShow, callInMenuHide) {
		inMenuShow = callInMenuShow;
		inMenuHide = callInMenuHide;
	};

	var menuControl = function () {
		if(!base.hasClass("show-menu"))
			return showMenu();

		hideMenu();
	};

	var showMenu = function () {
		base.addClass("show-menu");
		inMenuShow();
	};

	var hideMenu = function () {
		base.removeClass("show-menu");
		inMenuHide();
	};
	/*=====  End of Methods  ======*/


	/*================================
	=            Triggers            =
	================================*/
	menu.click(menuControl);
	/*=====  End of Triggers  ======*/
}