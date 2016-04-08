
		</div> <!-- .container -->
						
		<footer id="main-footer">

			<div id="localizacao">
				<div class="container vertical-center">
					<div class="inner-localizacao col-md-7 col-md-offset-3">
						<div class="col-lg-5">
							<button id="achar-localizacao" class="bt">
								<div id="map-marker">
									<i class="fa fa-map-marker fa-2"></i>
								</div> <!-- .map-marker -->

								<p> Achar minha localização automaticamente </p>
							</button> <!-- #achar-localizacao -->
						</div> <!-- .com-lg-5 -->

						<img src="<?= get_bloginfo('template_url') ?>/images/footer/divisao.png" alt="ou" class="divisao"/>

						<div class="col-lg-7 ">
							<div id="digitar-cep">
								<label for="cp-buscar-cep">
									Digite o CEP de onde você está
								</label>
								<form>
									<input type="text" name="cep" placeholder="CEP" id="cp-buscar-cep">
									<input type="submit" class="bt" value="Procurar">
								</form>
							</div> <!-- #digigar-cep -->
						</div> <!-- .col-lg-7 -->
					</div>
				</div> <!-- .container -->
			</div> <!-- #localizcao -->

			<div id="newsletter">
				<div class="inner container">
					<div class="row">
						<div class="col-md-6">
							<div class="box-newsletter">
								<label> Assine a newsletter do logo </label>
								<form>
									<input type="text" placeholder="Seu e-mail" name='newsletter_email'>
									<input type="submit" class="bt" value="Enviar">
								</form> <!-- form -->
							</div>
						</div> <!-- .col-md-6 -->

						<div class="col-md-6" id="redes-sociais">
							<p> Siga lojas logo nas redes sociais </p>
							<ul>
								<li> <a href="#"> <i class="fa fa-facebook"></i> </a> </li>
								<li> <a href="#"> <i class="fa fa-youtube"></i> </a> </li>
								<li> <a href="#"> <i class="fa fa-instagram"></i> </a>  </li>
							</ul>
						</div> <!-- .col-md-6 -->
					</div> <!-- .row -->
				</div> <!-- .inner -->
			</div> <!-- #newsletter -->

			<div class="container">

			<div class="row" id="inner-footer">
				<div class="col-md-8">
					<div class="col-md-3">
						<div id="mapa-site">
							<h4> Lojas Logo </h4>
							<ul>
								<?php 
									$args = array(
										'title_li' => '',
										'exclude'  => '46,44'
									);

									wp_list_pages($args); 
								?>
							</ul> <!-- #mapa -->
						</div> <!-- #mapa-site -->




					</div> <!-- .col-md-4 -->

					<div class="col-md-3">
						<div id="lista-atalhos">
							<h4> Lista de Atalhos </h4>
							<ul>
								<li> <a href='#'> Porta do Colaborador </a> </li>
								<li> <a href='#'> Promoções </a> </li>
								<li> <a href='<?php get_site_url() ?>/cartao-lojas-logo'> Cartão do Cliente </a> </li>
								<li> <a href='#'> Cadastre-se </a> </li>
								<li> <a href='#'> Blog </a> </li>
							</ul>
						</div> <!-- #lista-atalhos -->
					</div> <!-- .col-md-4 -->

					<div class="col-md-6">
						<div id="sac">
							<ul>
								<li> <h4>SAC Lojas Logo</h4> </li>
								<li> <h4>0800-701-0316</h4> </li>
							</ul>
						</div> <!-- #sac -->

						<div class="row">
							<div class="col-md-12">
								<button href="#" class="bt">
									<div class="codigo-barras">
										<i class="fa fa-barcode fa-2"></i>
									</div>
									Solicitar 2ª via do boleto
								</button> <!-- #achar-localizacao -->
							</div> <!-- col-md-4 -->
						</div> <!-- .row -->					
					</div> <!-- .col-md-4 -->

				</div> <!-- .col-md-7 -->

			</div> <!-- .row -->

			</div> <!-- .container -->



			<div class="container">
				<div class="row">
					<div class="col-md-12 copyright">
						<p> 2015, Lojas Logo. Todos os direitos reservados </p>
					</div> <!-- .col-md-12 -->
				</div> <!-- copyright -->
			</div>

			<div class="mkt">
				<img src="<?= get_bloginfo('template_url') ?>/images/mkt_virtual.png" alt="MKT Virtual"/>
			</div>
		</footer> <!-- #main-footer-->

	</div> <!-- container -->

	<script src="<?= get_bloginfo('template_url') ?>/js/jquery-1.12.2.min.js"></script> 
	<script src="<?= get_bloginfo('template_url') ?>/bootstrap/js/bootstrap.js"></script>

	<?php wp_footer(); ?>

</body>	
</html>