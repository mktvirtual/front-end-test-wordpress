$(document).ready(function(){
    var owl = $('.owl-carousel').owlCarousel({
        items:1,
        loop: true,
        lazyLoad: true,
        autoplay: true,
        autoplayHoverPause: true,
        autoplaySpeed: 2000,
        navSpeed: 2000
        //autoWidth: true
    });
    
    $('#next').click(function(){
        owl.trigger('next.owl.carousel');
    })
    
    $('#prev').click(function(){
        owl.trigger('prev.owl.carousel');
    });
    
    var lastScroll = 0;
    $(document).scroll(function(){
        $this = $(this);
        var st = $this.scrollTop();
        if(st < 50){ //grudou no topo
            $('#topo, #apoio').removeClass('hide shrink');
        }else if(st > lastScroll){ //rolando para baixo
            $('#topo').addClass('shrink top');
            $('#apoio').addClass('hide');
        }else{ //rolando para cima
            $('#topo, #apoio').addClass('shrink').removeClass('top hide');
        }
        lastScroll = st;
    });
    
    $('.cep').mask('00000-000')
})