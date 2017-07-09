//SCROLL
$(document).scroll(function() {
    if( $(window).width() > 768 ) {
        if ( $(this).scrollTop() !== 0 ) {
            $('.header-bottom').addClass('__scrolling');
        }else {
            $('.header-bottom').removeClass('__scrolling');
        }
    }
});
// /SCROLL

// SWIPER 
var swiperHome = new Swiper('#swiper__home', {
    autoplay: 8000,
    effect: 'fade',
    loop: true,
    pagination: '.swiper-pagination',
    paginationClickable: true,
});
// / SWIPER 

//OPEN SHOW
$( ".open-show" ).on( 'click', function(event) {
    event.stopPropagation();
    var type = $( this ).attr( "open-type" );
    
    switch(type) {
        case "parent":
            var object = $( this ).parents();
        break;
        case "object":
            var object = $( this ).attr( "data-open" );
            var object = $( object );
        break;
        default:
            var object = $( this );
        break;
    }
    
    switch(type) {
        case "object":
            var active = object.attr( "data-active" );
            var activeThis = $( this ).attr( "data-active" );
            object.attr( "data-active", "false" );
            $( this ).attr( "data-active", "false" );
            
            if( active != "true" && activeThis != "true" ) {
                object.attr( "data-active", "true" );
                $( this ).attr( "data-active", "true" );
            }
            
            if($( this ).attr( "data-overflow" )) {
                var overflow = $( this ).attr( "data-overflow" );
                var overflowActive = $( overflow ).hasClass( 'overflow' );
                $( overflow ).addClass( 'overflow' );
                
                if( overflowActive ) {
                    $( overflow ).removeClass( 'overflow' );
                }
                
            }
        break;
        default:
            var active = object.attr( "data-active" );
            object.attr( "data-active", "false" );
            $( ".open-show" ).attr( "data-active", "false" );
            
            if( active != "true" ) {
                object.attr( "data-active", "true" );
            }
        break;
    }
});

$( '.open-show, .open-show__content' ).on( 'click', function(event){
    event.stopPropagation();
});
// /OPEN SHOW