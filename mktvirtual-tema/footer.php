
		<footer>
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-2 col-xs-6">
								<div class="links-1">
									<div class="title"><p>LOJAS LOGO</p></div>
									<?php wp_nav_menu( array( 'theme_location' => 'footer-links' ) ); ?>
								</div>
							</div>
							<div class="col-md-2 col-xs-6">
								<div class="links-2">
									<div class="title"><p>Lista de atalhos</p></div>
									<?php wp_nav_menu( array( 'theme_location' => 'footer-atalhos' ) ); ?>
								</div>
							</div>
							<div class="col-md-3 col-xs-6">
								<div class="sac">
									<div class="title"><p>SAC loja logo</p><p>0800-701-0316</p></div>
									<a href=""><img src="<?php echo get_template_directory_uri() . '/images/barcode-icon.png';?>" alt="barcode"><h6>Solicitar 2ª via do boleto</h6></a>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
			<div class="footer-bottom">
				<div class="container">
					<div class="row">
						<div class="copyright">
							<p>0015, Lojas Logo. Todos os direitos reservados</p>
						</div>
						<div class="realization">
							<p>MKT VIRTUAL</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
</div>

<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/bootstrap.js';?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/main.js';?>"></script>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
      function initialize() {
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
          center: new google.maps.LatLng(44.5403, -78.5463),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
<script>
    $(document).ready(function() {
    $('#carousel-example-generic').carousel();

    $(".carousel-inner").bind("swipeleft", function(){
      $("a.right").click();
    });
    $(".carousel-inner").bind("swiperight", function(){
      $("a.left").click();
    });
    });                 
  
</script>
</body>
</html>