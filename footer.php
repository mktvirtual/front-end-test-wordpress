		<footer class="orange">
			<div class="central">
				<div id="col-1" class="col">
					<h3>
						LOJAS LOGO
					</h3>
					<ul class="ul-vertical-menu">
						<li>Sobre</li>
						<li>Lojas</li>
						<li>Trabalhe conosco</li>
						<li>Contato</li>
					</ul>
				</div>
				<div id="col-2" class="col">
				<h3>
					LISTA DE ATALHOS
				</h3>
					<ul class="ul-vertical-menu">
						<li>Portal do Colaborador</li>
						<li>Promoções</li>
						<li>Cartão do Cliente</li>
						<li>Cadastre-se</li>
						<li>Blog</li>
					</ul>
				</div>
				<div class="col">
					<h3>SAC LOJA LOGO</h3>&nbsp;<h3>0800-701-0316</h3>
					<div class="btn">
						<span class="icon">
							<span class="barcode-black-icon"></span>
						</span>
						<span class="text">
							<div class="inside">
								SOLICITAR 2ª VIA DO BOLETO	
							</div>
						</span>
					</div>
				</div>
			</div>
		</footer>
	<?php wp_footer(); ?>
	<script type="text/javascript">
	elId('btn-cep').addEventListener("click", function(){
   	getCEP(elId('txt-cep').value);
});

elId('btn-auto-local').addEventListener("click", function(){
   	getLocation();
});</script>
	</body>
</html>