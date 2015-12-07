<?php get_header(); ?>

    <!-- Banner -->
    <section id="slider">
      <?php echo do_shortcode( '[metaslider id=33]' ); ?>
    </section>

    <!-- Dinamico -->
    <section id="dinamico">
      <div class="row">
        <div class="column medium-4">
          <?php query_posts(array( 'post_type' => 'superbanner' )); ?>
          <?php while (have_posts()) : the_post(); ?>
          <?php $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false )[0]; ?>
            <a class="superbanner" href="" style="background: url('<?php echo $img ?>') no-repeat center center;">
              <span><?php the_title(); ?></span>
            </a>
          <?php endwhile; wp_reset_query(); ?>
        </div>
        <div class="column medium-8">
          <ul class="small-block-grid-1 medium-block-grid-2">
            <?php query_posts(array(
              'posts_per_page' => '4',
              'category_name' => 'beleza, moda-logo, promocoes',
              'order' => 'ASC' 
            )); ?>
            <?php while ( have_posts() ) : the_post(); ?>
            <li class="post-container">
              <div class="post-foto">
                <?php the_post_thumbnail(); ?>   
              </div>
              <?php $posicaotexto = types_render_field("posicao-texto", array()); ?>
              <div class="text-holder <?php echo $posicaotexto ?>">
                <?php $categories = get_the_category(); ?>
                <?php $cat_name = $categories[0]->cat_name; ?>
                <div class="row show-for-large-up post-category"><?php echo $cat_name ?></div>
                <div class="row post-name"><h3><?php echo the_title(); ?></h3></div>
                <div class="row post-descript alegreya"><?php echo the_excerpt(); ?></div>
                
              </div>
            </li>
            <?php endwhile; wp_reset_query(); ?>
          </ul>

        </div>
      </div>
    </section>

    <!-- GMAPS -->
    <section id="gmaps">
      <div id="map"></div>
      <script type="text/javascript">

      function initMap() {

        // Specify features and elements to define styles.
        var styleArray = [
          {
            featureType: "all",
            stylers: [
             { hue: "#f45d2e" },
             { lightness: 50 }
            ]
          }
        ];

        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -23.9549052, lng: -46.3624985},
          scrollwheel: false,
          zoomControl: false,
          mapTypeControl: false,
          scaleControl: false,
          streetViewControl: false,
          rotateControl: false,
          // Apply the map style array to the map.
          styles: styleArray,
          zoom: 11
        });
      }

      </script>
      <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxrDBGmL_ye9Qs0rroJg-FzCGo6X_BH_0&callback=initMap">
      </script>
      <div class="map-overlay">
        <div class="row">
          <div class="column medium-5">
            <button class="location">Achar minha localização automaticamente</button>
          </div>

          <div class="column small-centered medium-uncentered small-7 medium-1">
            <span class="span-tracos">ou</span>
          </div>

          <div class="column medium-6">
            <form action="">
              <div class="row">
                <div class="column">
                  <label class="label-campo-cinza">digite o cep de onde você está</label>
                </div>  
              </div>

              <div class="row collapse campo-cinza">
                <div class="small-7 columns">
                  <input type="text" placeholder="CEP">
                </div>

                <div class="small-5 columns bg">
                  <a href="#" class="button postfix">Procurar</a>
                </div>
              </div> 
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- NEWSLETTER e SOCIAL -->
    <section class="whitespace">
      <div class="row">
        <div class="column medium-6">
          <h4>Assine a newsletter do logo</h4>
          <form>
            <div class="row collapse campo-cinza">
              <div class="small-8 columns">
                <input type="text" placeholder="Seu e-mail">
              </div>

              <div class="small-4 columns bg">
                <a href="#" class="button postfix">Enviar</a>
              </div>
            </div>          
          </form>
        </div>

        <div class="column medium-6">
          <h4>Siga lojas logo nas redes sociais</h4>
          <a href="#" class="button social-icons">f</a>
          <a href="#" class="button social-icons">y</a>
          <a href="#" class="button social-icons">i</a>
        </div>    
      </div>
    </section>

<?php get_footer(); ?>
