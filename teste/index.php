<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">

  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:400,500|Montserrat:400,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.0/css/swiper.min.css">
  <?php wp_head(); ?>
</head>
<body>

<?php get_header(); ?>


<div class="swiper-container slider">
  <div class="swiper-wrapper">
    <?php
      $sliderArgs = array( 'post_type' => 'slider');
      $sliderLoop = new WP_Query( $sliderArgs );
      while ( $sliderLoop->have_posts() ) : $sliderLoop->the_post();  ?>
      <div class="swiper-slide" data-swiper-autoplay="5000"><img src="<?php the_post_thumbnail_url() ?>" alt=""></div>
    <?php endwhile; ?>
  </div>
  <div class="swiper-pagination"></div>
</div>


<div class="container flex-container main-content">
  <div class="column-small super-banner">
    <figure class="card-super-banner">
      <img src="<?php echo get_theme_mod('superBanner') ?>" alt="">
      <a href="#" class="btn-super-banner">Preencha a proposta de adesão</a>
    </figure>
  </div>
  <section class="column-large posts-featured">
    <?php query_posts('showposts=4'); if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php $color = get_post_meta($post->ID, 'meta_box_select', true);  ?>
      <article class="card">
        <div class="content <?php echo $color; ?>">
          <h1 class="post-title"><?php the_title(); ?></h1>
          <div class="excerpt"><?php the_excerpt(100, 'content') ?></div>
          <div class="btn-primary">
             <a href="<?php the_permalink() ?>" class='item'>Saiba Mais</a>
          </div>
        </div>
        <figure>
          <img class='image-featured' src="<?php the_post_thumbnail_url() ?>" alt="" width='412' height='412'>
        </figure>
      </article>
    <?php endwhile; ?>
    <?php endif ?>
   </section>
</div>

<div class="localization">
  <div class="map">
     <div id="panel-map" class="panel-map">
      <div class="wrapper-button">
        <div class="btn-primary btn-2x">
          <div class="pin-map">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
          </div>
          <a href="#" class="btn-localization">Achar minha localização automaticamente</a>
        </div>

      </div>
      <span class="separator">ou</span>
      <form action="" class="form-map">
        <legend>Digite o cep da onde você está</legend>
        <fieldset class="form-group">
          <input class='input-default' id="address" type="textbox" placeholder='cep' value="">
          <input class='btn-primary btn-submit' id="submit" type="button" value="procurar">
        </fieldset>
      </form>
    </div>

  <div id="map"></div>
  </div>
</div>


<div class="top-footer">
  <div class="container flex-container">
    <div class="newsletter">
      <form action="" class="form-map">
        <fieldset class="form-group">
          <legend>Assine a newsletter do logo</legend>
          <input class='input-default' id="newsletter" type="textbox" placeholder='cep' value="">
          <input class='btn-primary btn-submit' id="submit-newsletter" type="button" value="procurar">
        </fieldset>
      </form>
    </div>
    <div class="social-network">
      <p class="title">Siga lojas nas redes sociais</p>
      <div class="social-item">
        <a href="#" class="item"><i class="fa fa-facebook" aria-hidden="true"></i></a>
      </div>
      <div class="social-item">
        <a href="#" class="item"><i class="fa fa-twitter" aria-hidden="true"></i></a>
      </div>
      <div class="social-item">
        <a href="#" class="item"><i class="fa fa-instagram" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
</div>
<?php get_footer() ?>
<script src="https://use.fontawesome.com/962fb0ff11.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.0/js/swiper.jquery.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
   var mySwiper = new Swiper('.swiper-container',{
     pagination: '.pagination',
     grabCursor: true,
      speed: 1000,
      spaceBetween: 100,
      autoplay: true,
     paginationClickable: true
   });
   jQuery('.arrow-left').on('click', function(e){
     e.preventDefault()
     mySwiper.swipePrev()
   });
   jQuery('.arrow-right').on('click', function(e){
     e.preventDefault()
     mySwiper.swipeNext()
   });
});
 </script>
<script>
  var styleArray = [
    {
      stylers: [
        { hue: "#ff8e86" },
        { saturation: -60 }
      ]
    },{
      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: 100 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "off" }
      ]
    }
  ];

  function initMap() {
    // Create a map object and specify the DOM element for display.
    var submit = document.getElementById('submit'),
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -23.9679, lng: -46.3289},
          scrollwheel: false,
          zoom: 13,
          styles: styleArray
        });
    var geocoder = new google.maps.Geocoder();

    submit.addEventListener('click', function() {
      geocodeAddress(geocoder, map);
    });

  }

  function geocodeAddress(geocoder, resultsMap) {
    var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function(results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
        resultsMap.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
          map: resultsMap,
          position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAykqzIBrQPHNAvWNBio7I1s-Z7nv9GlIE&callback=initMap"
    async defer></script>
  <script src='<?php echo get_template_directory_uri(); ?>/public/scripts/plugins/sticky.min.js'></script>
  <script>
    new Sticky({
        target: 'header',
        offset: 100
    });
  </script>
</body>
</html>
