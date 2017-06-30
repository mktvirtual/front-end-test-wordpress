<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


<div class="container-fluid">
        <!-- fim header. -->
     <div class="row">
          <div class="imagem-header">
                <img class="imagem" src="<?php echo bloginfo('url') ?>\wp-content\themes\twentyseventeen\assets\images\header1.png">
                <div class="mainnav col-md-12 col-xs-12">
			<?php wp_nav_menu( array('menu' => 'header-topo' )); ?>
			
			
               
        </div>       
          </div>  
    </div>
    <!-- fotos. -->

     <div class="row fotos">
        <div class="col-md-offset-2 col-md-8">
          <div class="col-md-4 col-xs-6">
          <img class="img-responsive" style="height: 600px; width:800px;"  src="<?php echo bloginfo('url') ?>\wp-content\themes\twentyseventeen\assets\images\retangulo.png">
          </div>            
          <div class="col-md-4 col-xs-6 ">
              <div class="col-sm-6 col-md-12 quadrado">
                 <img class="img-responsive" style="height: 300px; width:400px"  src="<?php echo bloginfo('url') ?>\wp-content\themes\twentyseventeen\assets\images\quadrado1.png"> 
              </div>
              <div class="col-sm-6 col-md-12 quadrado">
              <img class="img-responsive" style="height: 300px; width:400px" src="<?php echo bloginfo('url') ?>\wp-content\themes\twentyseventeen\assets\images\quadrado2.png">
              </div>   
          </div>   

          <div class="col-md-4 col-sm-6 ">
              <div class="col-md-12 col-xs-6 quadrado">
                  <img class="img-responsive" style="height: 300px;" src="<?php echo bloginfo('url') ?>\wp-content\themes\twentyseventeen\assets\images\quadrado3.png">
              </div>
              <div class="col-md-12 col-xs-6 quadrado">
                  <img class="img-responsive" style="height: 300px" src="<?php echo bloginfo('url') ?>\wp-content\themes\twentyseventeen\assets\images\quadrado4.png">
              </div>   
          </div>     
        </div>
    </div>
    <!-- fim fotos -->

     <!-- mapa -->
     <div class="row">
    <div class="col-md-12 col-xs-12 googleMap"> 
    <div id="googleMap" style="width:100%;height:400px;"></div>

    <script>
        function myMap() {
        var mapProp= {
            center:new google.maps.LatLng(-23.953686,-46.370395),
            zoom:5,
        };
        var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBo_QKGgWDMjEIpxDX6LMYrQc5PUDdngNo&callback=myMap"></script>
    </div>
    <!-- fim mapa -->

    <div class="col-md-4 col-xs-12 newsletter ">
        <div class="email col-md-8 col-sm-6 ">
            Assine a Newsletter do logo:<br><br>
            <input type="text" name="Newsletter" placeholder="Seu e-mail">
            <button name="Enviar" class="btn">Enviar</button><br>
        </div>

        <div class="social col-md-4 col-sm-6 ">
           <p>Siga lojas logo nas redes sociais:</p><br><br>
             <div class="compartilha col-xs-6">
                <i class="fa fa-facebook-square"></i>
                <i class="fa fa-youtube-play"></i>
                <i class="fa fa-instagram"></i>
            </div>
        </div>
    </div>

    </div>
    <div class="row">
   <?php get_footer();?>

    </div>
  </div>

