$(document).ready(function () {
    'use strict';

    var top,
        menu,
        banners,
        location;

    /*=================================
    =            Callbacks            =
    =================================*/
    var showMenu = function () {
    	banners.pauseSlider();
    	top.removeHelping();
    };

    var hideMenu = function () {
    	banners.playSlider();
    };
    /*=====  End of Callbacks  ======*/


    /*================================
    =            Inputers            =
    ================================*/
    var inputer = function () {
        menu.inputer(showMenu, hideMenu);
    }
    /*=====  End of Inputers  ======*/


    /*=================================
    =            Bootstrap            =
    =================================*/
    var init = function () {
        banners  = new Banners(),
        location = new Location();

        if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
            return;

        top  = new Top(),
        menu = new Menu();

        inputer();
    };

    init();
    /*=====  End of Bootstrap  ======*/
});