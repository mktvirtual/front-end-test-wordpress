/* Aqui vão ficar os scripts do site */

$(document).ready(function() {


    /*Ação do botão de menu do site mobile*/
    $('#bto-menu-mobile').click(function(){
        $(this).toggleClass('fa-bars');
        $(this).toggleClass('fa-times');
        $('.nav-mobile').toggleClass('nav-active');
    });
    /*Ação do botão de menu do site mobile*/


    /*Banner Site*/
    $("#banner-site").owlCarousel({
        singleItem: true,
        items: 1,
        navigation: true,
        pagination: true,
        paginationNumbers: false,
        autoPlay: true
    });
    /*Banner Site*/


});