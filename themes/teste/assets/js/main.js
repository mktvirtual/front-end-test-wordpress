$(document).ready(function(){

    // HOME SLIDER
    $('.slide-container').slick({
        autoplay : true,
        dots     : true,
        infinite : true,
        speed    : 500,
        fade     : true,
        centerMode: true,
        prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
        nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
        cssEase  : 'linear'
    });

    // Maskara do CEP
    $("#cep").mask("99999-999");

    // Script de Submenu do Menu padrão
    $("#menu-default > li").hover(function () {
        $(this).children(".sub-menu").fadeIn(300);
    },
    function () {
        $(this).children(".sub-menu").fadeOut(300);
    });

    // Script de botão abre/fecha menu (responsivo)
    $('#menu-toggle').click(function(){
		$(this).toggleClass('open');
        $('.menu-default-container').toggleClass('open');
        $('.menu-default-container').delay(5000).toggleClass('shadow');
    });

    // Centralizar controles do Script de Localização e CEP
    center('.maps-control', '#maps');

    $( window ).resize(function() {
        center('.maps-control', '#maps');
    });

});

function center(el, target) {

    el = $(el);
    target = $(target);
    el.css("top", Math.max(0, ((target.height() - el.outerHeight()) / 2) + target.scrollTop()) + "px");
    el.css("left", Math.max(0, ((target.width() - el.outerWidth()) / 2) + target.scrollLeft()) + "px");
    return this;

}


// HEADER fixed
var myElement = document.querySelector("header");
var headroom  = new Headroom(myElement);
headroom.init();


// GOOGLE MAPS
var _userLat = null;
var _userLng = null;
var _map	 = null;
var _geocoder = new google.maps.Geocoder();


function getCep(zipCode) {

    _geocoder.geocode( { 'address': zipCode + ', Brasil', 'region': 'BR' }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {

                var _userLat = results[0].geometry.location.lat();
                var _userLng = results[0].geometry.location.lng();

                centerMap(_userLat, _userLng);

            }
        }
        else {
            console.log("Erro ao adquirir resposta: " + status);
        }
    });
}

function askGeolocation(){

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(setLatLong);
    } else {
        console.log("Geolocation não é suportado pelo seu browser.");
    }

}
function setLatLong(position){

    _userLat 	= position.coords.latitude;
    _userLng 	= position.coords.longitude;

    centerMap(_userLat, _userLng);

}
function generateMap(){

    var _styles = [{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"landscape.natural.landcover","elementType":"all","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"landscape.natural.terrain","elementType":"all","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"on"},{"color":"#f4ddd9"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#f4ddd9"}]},{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"administrative","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"#f38181"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"}]}];

    _map = new google.maps.Map(document.getElementById('map'), {
        zoom              : 14,
        center            : {lat: -23.9549296, lng: -46.4150293},
        scrollwheel       : false,
        navigationControl : false,
        mapTypeControl    : false,
        scaleControl      : false,
        styles            : _styles
    });

}
function centerMap(lat, lng){

    _map.setCenter(new google.maps.LatLng(lat, lng));
    var marker = new google.maps.Marker({
        map: _map,
        position: {lat: lat, lng: lng}
    });

}
function init(){
    generateMap();
}

init();
