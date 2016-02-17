function Menu () {
	"use strict";

	/*==================================
	=            References            =
	==================================*/
	var menu = $("#menu"),
		base = $("#base");
	/*=====  End of References  ======*/


	/*===============================
	=            Methods            =
	===============================*/
	var showMenu = function () {
		if(base.hasClass("show-menu"))
			return base.removeClass("show-menu");

		base.addClass("show-menu");
	};
	/*=====  End of Methods  ======*/


	/*================================
	=            Triggers            =
	================================*/
	menu.click(showMenu);
	/*=====  End of Triggers  ======*/
}