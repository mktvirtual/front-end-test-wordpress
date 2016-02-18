$(document).ready(function () {
    'use strict';

    /*=================================
    =            Bootstrap            =
    =================================*/
    var top     = new Top(),
    	menu    = new Menu(),
    	banners = new Banners();

    new Location();
    /*=====  End of Bootstrap  ======*/


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
    menu.inputer(showMenu, hideMenu);
    /*=====  End of Inputers  ======*/
});