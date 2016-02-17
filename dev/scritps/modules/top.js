function Top () {
	"use strict";

	/*==================================
	=            References            =
	==================================*/
	var w     = $(window),
		top   = $(".top"),
		arrow = $("#arrow");
	/*=====  End of References  ======*/


	/*===============================
	=            Methods            =
	===============================*/
	var lastScreenPosition = 0;

	var checkScreenPosition = function () {
		if(top.hasClass("opened"))
			return;

		if(w.scrollTop() > lastScreenPosition)
			top.removeClass("helping");
		else
			top.addClass("helping");


		lastScreenPosition = w.scrollTop();
	};

	var changeTopPosition = function () {
		top.removeClass("helping");

		if(top.hasClass("opened"))
			return top.removeClass("opened");

		top.addClass("opened")
	};
	/*=====  End of Methods  ======*/


	/*================================
	=            Triggers            =
	================================*/
	w.scroll(checkScreenPosition);
	arrow.click(changeTopPosition);
	/*=====  End of Triggers  ======*/
}